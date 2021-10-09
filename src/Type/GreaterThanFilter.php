<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class GreaterThanFilter extends ComparisonFilter
{
    protected function getOperator(): string
    {
        return '>';
    }
}
