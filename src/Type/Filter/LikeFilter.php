<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

abstract class LikeFilter extends ComparisonFilter
{
    public function __construct(string $compareTo)
    {
        parent::__construct($compareTo);
    }

    protected function getOperator(): string
    {
        return 'LIKE';
    }
}
