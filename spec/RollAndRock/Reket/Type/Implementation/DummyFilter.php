<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\Filter;

class DummyFilter extends Filter
{
    use DummyGatherableFilterTrait;

    public function toSQL(): string
    {
        return '';
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }
}
