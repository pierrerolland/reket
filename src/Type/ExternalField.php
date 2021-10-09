<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class ExternalField implements Gatherable
{
    abstract public function getConnector(): Connector;

    abstract public function getBaseField(): Field;

    public function getSource(): Source
    {
        return $this->getBaseField()->getSource();
    }

    public function toSQL(): string
    {
        return sprintf('%s.%s', $this->getConnector()->getConnectingAlias(), $this->getBaseField()->getName());
    }
}
