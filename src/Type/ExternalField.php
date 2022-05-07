<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class ExternalField implements FieldGatherable
{
    abstract public function getConnector(): Connector;

    abstract public function getBaseField(): Field;

    abstract public function getAlias(): ?string;

    public function getSource(): Source
    {
        return $this->getBaseField()->getSource();
    }

    public function toSQL(): string
    {
        return sprintf(
            '%s%s',
            $this->toUnaliasedSQL(),
            null !== $this->getAlias() ? ' AS ' . $this->getAlias() : ''
        );
    }

    public function toUnaliasedSQL(): string
    {
        return sprintf(
            '%s.%s',
            $this->getConnector()->getConnectingAlias(),
            $this->getBaseField()->getName()
        );
    }
}
