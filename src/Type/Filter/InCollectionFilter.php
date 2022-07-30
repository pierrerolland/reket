<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

abstract class InCollectionFilter extends GatherableFilter
{
    public function __construct(array $collection)
    {
        $this->parameters = $collection;
    }

    public function toSQL(): string
    {
        return sprintf(
            '%s IN (%s)',
            $this->toFilter()->toUnaliasedSQL(),
            implode(', ', array_fill(0, count($this->parameters), '?'))
        );
    }
}
