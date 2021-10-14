<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Expression;
use RollAndRock\Reket\Type\Filter\Filter;
use RollAndRock\Reket\Type\Gatherable;

class DummyExpression extends Expression
{
    /**
     * @param Gatherable[] $gatherables
     */
    public function setGatherables(array $gatherables): void
    {
        foreach ($gatherables as $gatherable) {
            $this->gather($gatherable);
        }
    }

    /**
     * @param Filter[] $filters
     */
    public function setFilters(array $filters): void
    {
        foreach ($filters as $filter) {
            $this->apply($filter);
        }
    }
}
