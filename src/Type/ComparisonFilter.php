<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class ComparisonFilter extends Filter
{
    /**
     * @var mixed
     */
    protected $compareTo;

    /**
     * @param mixed $compareTo
     */
    public function __construct($compareTo)
    {
        $this->compareTo = $compareTo;
    }

    abstract protected function getOperator(): string;

    public function toSQL(): string
    {
        if (!$this->compareTo instanceof Gatherable) {
            $this->parameters = [$this->compareTo];

            return sprintf('%s %s ?', $this->getGatherableToFilter()->toSQL(), $this->getOperator());
        }

        return sprintf(
            '%s %s %s',
            $this->getGatherableToFilter()->toSQL(),
            $this->getOperator(),
            $this->compareTo->toSQL()
        );
    }
}
