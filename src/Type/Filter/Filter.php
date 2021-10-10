<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

use RollAndRock\Reket\Type\SQLConvertable;

abstract class Filter implements SQLConvertable
{
    protected array $parameters = [];

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
