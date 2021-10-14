<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class Field implements FieldGatherable
{
    public function toSQL(): string
    {
        return sprintf(
            '%s.%s%s',
            $this->getSource()->getConnectingAlias() ?: $this->getSource()->getName(),
            $this->getName(),
            null !== $this->getAlias() ? ' AS ' . $this->getAlias() : ''
        );
    }

    abstract public function getSource(): Source;

    abstract public function getName(): string;

    abstract public function getAlias(): ?string;
}
