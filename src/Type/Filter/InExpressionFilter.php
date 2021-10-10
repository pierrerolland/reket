<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

use RollAndRock\Reket\Type\Expression;

abstract class InExpressionFilter extends GatherableFilter
{
    private Expression $expression;

    public function __construct(Expression $expression)
    {
        $this->expression = $expression;
    }

    public function toSQL(): string
    {
        return sprintf('IN ( %s )', $this->expression->toSQL());
    }

    public function getParameters(): array
    {
        return $this->expression->getParameters();
    }
}
