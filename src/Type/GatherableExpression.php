<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class GatherableExpression extends Expression implements Gatherable
{
    public function toSQL(): string
    {
        return sprintf('%s AS %s', $this->toUnaliasedSQL(), $this->getAlias());
    }

    public function toUnaliasedSQL(): string
    {
        return sprintf('( %s )', parent::toSQL());
    }

    abstract public function getAlias(): string;
}
