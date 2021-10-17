<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Exception\SourceNotFoundInExpressionException;
use RollAndRock\Reket\Exception\TooManySourcesInExpressionException;
use RollAndRock\Reket\Transformer\FiltersToSQLTransformer;
use RollAndRock\Reket\Transformer\GatherableToSQLTransformer;
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
            '%s %s%s',
            GatherableToSQLTransformer::transform($this->gatherables),
            SourcesToSQLTransformer::transform($this->source, $this->connectors),
            FiltersToSQLTransformer::transform($this->filters, FiltersToSQLTransformer::CONTEXT_WHERE)
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
}
