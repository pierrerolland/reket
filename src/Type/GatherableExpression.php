<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class GatherableExpression extends Expression implements Gatherable
{
    public function toSQL(): string
    {
        return sprintf('( %s ) AS %s', parent::toSQL(), $this->getAlias());
    }

    abstract public function getAlias(): string;
}
