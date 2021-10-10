<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

use RollAndRock\Reket\Type\Gatherable;

abstract class BetweenFilter extends GatherableFilter
{
    /**
     * @var mixed
     */
    protected $min;

    /**
     * @var mixed
     */
    protected $max;

    /**
     * @param mixed $min
     * @param mixed $max
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function toSQL(): string
    {
        if (!$this->min instanceof Gatherable) {
            $this->parameters[] = $this->min;
        }
        if (!$this->max instanceof Gatherable) {
            $this->parameters[] = $this->max;
        }

        return sprintf(
            '%s BETWEEN %s AND %s',
            $this->toFilter()->toSQL(),
            $this->min instanceof Gatherable ? $this->min->toSQL() : '?',
            $this->max instanceof Gatherable ? $this->max->toSQL() : '?'
        );
    }
}
