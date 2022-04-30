<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\ConnectingField;
use RollAndRock\Reket\Type\Source;

class DummyConnectingField extends ConnectingField
{
    use DummyAliasableTrait;

    private string $name;

    private Source $source;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function setSource(Source $source): void
    {
        $this->source = $source;
    }
}
