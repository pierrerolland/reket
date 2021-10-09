<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter;
use RollAndRock\Reket\Type\Gatherable;

class DummyFilter extends Filter
{
    private Gatherable $toFilter;

    protected function getGatherableToFilter(): Gatherable
    {
        return $this->toFilter;
    }

    public function toSQL(): string
    {
        return '';
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }
}
