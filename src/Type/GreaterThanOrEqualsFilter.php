<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class GreaterThanOrEqualsFilter extends ComparisonFilter
{
    protected function getOperator(): string
    {
        return '>=';
    }
}
