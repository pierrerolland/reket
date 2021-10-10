<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

abstract class GreaterThanFilter extends ComparisonFilter
{
    protected function getOperator(): string
    {
        return '>';
    }
}
