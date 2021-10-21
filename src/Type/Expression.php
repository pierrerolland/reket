<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Exception\SourceNotFoundInExpressionException;
use RollAndRock\Reket\Exception\TooManySourcesInExpressionException;
use RollAndRock\Reket\Transformer\FiltersToSQLTransformer;
use RollAndRock\Reket\Transformer\GatherableToSQLTransformer;
use RollAndRock\Reket\Transformer\SortablesToSQLTransformer;
use RollAndRock\Reket\Transformer\SourcesToSQLTransformer;
use RollAndRock\Reket\Type\Filter\Filter;

abstract class Expression implements SQLConvertable
{
    /**
     * @var Gatherable[]
     */
    private array $gatherables = [];

    /**
     * @var Filter[]
     */
    private array $filters = [];

    /**
     * @var Sortable[]
     */
    private array $sortables = [];

    private ?int $maxResults = null;

    private ?int $startAt = null;

    private ?Source $source = null;

    /**
     * @var Connector[]
     */
    private array $connectors = [];

    /**
     * @throws SourceNotFoundInExpressionException
     * @throws TooManySourcesInExpressionException
     */
    public function toSQL(): string
    {
        $this->retrieveSources();

        return sprintf(
            '%s %s%s%s%s%s',
            GatherableToSQLTransformer::transform($this->gatherables),
            SourcesToSQLTransformer::transform($this->source, $this->connectors),
            FiltersToSQLTransformer::transform($this->filters, FiltersToSQLTransformer::CONTEXT_WHERE),
            SortablesToSQLTransformer::transform($this->sortables),
            null !== $this->maxResults ? sprintf(' LIMIT %d', $this->maxResults) : '',
            null !== $this->startAt ? sprintf(' OFFSET %d', $this->startAt) : ''
        );
    }

    /**
     * @throws SourceNotFoundInExpressionException
     * @throws TooManySourcesInExpressionException
     */
    private function retrieveSources(): void
    {
        foreach ($this->gatherables as $gatherable) {
            if ($gatherable instanceof Field) {
                if (null === $this->source) {
                    $this->source = $gatherable->getSource();
                } elseif ($this->source->getName() !== $gatherable->getSource()->getName()) {
                    throw new TooManySourcesInExpressionException();
                }
            } elseif ($gatherable instanceof ExternalField) {
                $this->connectors[get_class($gatherable->getConnector())] = $gatherable->getConnector();
            }
        }

        if (null === $this->source) {
            throw new SourceNotFoundInExpressionException();
        }
    }

    public function getParameters(): array
    {
        $out = [];

        foreach ($this->filters as $filter) {
            $out = array_merge($out, $filter->getParameters());
        }

        return $out;
    }

    protected function gather(Gatherable $gatherable): Expression
    {
        $this->gatherables[] = $gatherable;

        return $this;
    }

    protected function apply(Filter $filter): Expression
    {
        $this->filters[] = $filter;

        return $this;
    }

    protected function sortWith(Sortable $sortable): Expression
    {
        $this->sortables[] = $sortable;

        return $this;
    }

    protected function cut(?int $maxResults, ?int $startAt = null): void
    {
        $this->maxResults = $maxResults;
        $this->startAt = $startAt;
    }
}
