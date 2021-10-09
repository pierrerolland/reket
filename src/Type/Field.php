<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class Field implements Gatherable
{
    abstract public function getSource(): Source;

    abstract public function getName(): string;

    public function toSQL(): string
    {
        return sprintf('%s.%s', $this->getSource()->getName(), $this->getName());
    }
}
