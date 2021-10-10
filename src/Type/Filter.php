<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class Filter implements SQLConvertable
{
    protected array $parameters = [];

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
