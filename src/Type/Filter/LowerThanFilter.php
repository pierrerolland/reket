<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

abstract class LowerThanFilter extends ComparisonFilter
{
    protected function getOperator(): string
    {
        return '<';
    }
}
