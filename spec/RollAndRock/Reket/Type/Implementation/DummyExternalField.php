<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;

class DummyExternalField extends ExternalField
{
    use DummyAliasableTrait;

    private Connector $connector;

    private Field $baseField;

    public function getConnector(): Connector
    {
        return $this->connector;
    }

    public function setConnector(Connector $connector): void
    {
        $this->connector = $connector;
    }

    public function getBaseField(): Field
    {
        return $this->baseField;
    }

    public function setBaseField(Field $baseField): void
    {
        $this->baseField = $baseField;
    }
}
