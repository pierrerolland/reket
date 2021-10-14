<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\Filter;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\GatherableExpression;

class DummyGatherableExpression extends GatherableExpression
{
    private string $alias;

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

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }
}
