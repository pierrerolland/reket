<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class SourceExpression extends Expression implements Source
{
    public function getName(): string
    {
        return $this->getConnectingAlias();
    }

    abstract public function getConnectingAlias(): string;
}
