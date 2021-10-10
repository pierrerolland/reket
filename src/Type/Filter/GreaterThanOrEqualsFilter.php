<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

use RollAndRock\Reket\Type\Filter\ComparisonFilter;

abstract class GreaterThanOrEqualsFilter extends ComparisonFilter
{
    protected function getOperator(): string
    {
        return '>=';
    }
}
