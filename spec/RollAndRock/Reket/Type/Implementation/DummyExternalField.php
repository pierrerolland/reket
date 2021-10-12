<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;

class DummyExternalField extends ExternalField
{
    private Connector $connector;

    private Field $baseField;

    private ?string $alias = null;

    public function getConnector(): Connector
    {
        return $this->connector;
    }

    public function getBaseField(): Field
    {
        return $this->baseField;
    }

    public function setConnector(Connector $connector): void
    {
        $this->connector = $connector;
    }

    public function setBaseField(Field $baseField): void
    {
        $this->baseField = $baseField;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }
}
