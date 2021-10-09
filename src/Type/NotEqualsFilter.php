<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class NotEqualsFilter extends ComparisonFilter
{
    protected function getOperator(): string
    {
        return '<>';
    }

    public function toSQL(): string
    {
        if (null === $this->compareTo) {
            return sprintf('%s IS NOT NULL', $this->toFilter()->toSQL());
        }

        return parent::toSQL();
    }
}
