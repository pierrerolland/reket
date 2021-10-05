<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Exception\TooManySourcesInExpressionException;
use RollAndRock\Reket\Transformer\FieldsToSQLTransformer;
use RollAndRock\Reket\Transformer\SourcesToSQLTransformer;

abstract class Expression
{
    /**
     * @var Field[]|ExternalField[]
     */
    protected array $fields = [];

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
            FieldsToSQLTransformer::transform($this->fields),
            SourcesToSQLTransformer::transform($this->source, $this->connectors)
        );
    }

    /**
     * @throws TooManySourcesInExpressionException
     */
    private function retrieveSources(): void
    {
        foreach ($this->fields as $field) {
            if ($field instanceof Field) {
                if (null === $this->source) {
                    $this->source = $field->getSource();
                } elseif ($this->source->getName() !== $field->getSource()->getName()) {
                    throw new TooManySourcesInExpressionException();
                }
            } elseif ($field instanceof ExternalField) {
                $this->connectors[get_class($field->getConnector())] = $field->getConnector();
            }
        }
    }
}
