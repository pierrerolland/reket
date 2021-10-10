<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class GatherableFilter extends Filter
{
    abstract protected function toFilter(): Gatherable;
}
