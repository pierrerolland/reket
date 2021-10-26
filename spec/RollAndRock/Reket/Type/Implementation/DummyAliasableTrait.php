<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

trait DummyAliasableTrait
{
    private ?string $alias = null;

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }
}
