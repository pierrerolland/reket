<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

abstract class ChoicesFilter extends Filter
{
    /**
     * @var Filter[]
     */
    protected array $choices;

    /**
     * @param Filter[] $choices
     */
    public function __construct(array $choices)
    {
        $this->choices = $choices;
    }

    public function toSQL(): string
    {
        return sprintf('(%s)', implode(') OR (', array_map(fn (Filter $filter) => $filter->toSQL(), $this->choices)));
    }
}
