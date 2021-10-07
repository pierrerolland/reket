<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Exception\TooManySourcesInExpressionException;
use RollAndRock\Reket\Transformer\GatherableToSQLTransformer;
use RollAndRock\Reket\Transformer\SourcesToSQLTransformer;

abstract class Expression
{
    /**
     * @var Gatherable[]
     */
    protected array $gatherables = [];

    private ?Source $source = null;

    /**
     * @var Connector[]
     */
    private array $connectors = [];

    abstract public function create(): Expression;

    /**
     * @throws TooManySourcesInExpressionException
     */
    public function toSQL(): string
    {
        $this->retrieveSources();

        return sprintf(
            '%s %s',
            GatherableToSQLTransformer::transform($this->gatherables),
            SourcesToSQLTransformer::transform($this->source, $this->connectors)
        );
    }

    /**
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
    }
}
