<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\ComparisonFilter;

class DummyComparisonFilter extends ComparisonFilter
{
    use DummyGatherableFilterTrait;

    private string $operator;

    protected function getOperator(): string
    {
        return $this->operator;
    }

    public function setOperator(string $operator): void
    {
        $this->operator = $operator;
    }
}
