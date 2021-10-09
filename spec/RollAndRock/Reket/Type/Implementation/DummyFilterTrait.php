<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Gatherable;

trait DummyFilterTrait
{
    private Gatherable $toFilter;

    protected function toFilter(): Gatherable
    {
        return $this->toFilter;
    }

    public function setToFilter(Gatherable $toFilter): void
    {
        $this->toFilter = $toFilter;
    }
}
