<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

use RollAndRock\Reket\Type\Gatherable;

abstract class GatherableFilter extends Filter
{
    abstract protected function toFilter(): Gatherable;
}
