<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Source;

class DummyField extends Field
{
    private Source $source;

    private string $name;

    private ?string $alias = null;

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setSource(Source $source): void
    {
        $this->source = $source;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }
}
