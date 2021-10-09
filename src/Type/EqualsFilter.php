<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class EqualsFilter extends ComparisonFilter
{
    protected function getOperator(): string
    {
        return '=';
    }

    public function toSQL(): string
    {
        if (null === $this->compareTo) {
            return sprintf('%s IS NULL', $this->toFilter()->toSQL());
        }

        return parent::toSQL();
    }
}
