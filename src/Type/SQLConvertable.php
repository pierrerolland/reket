<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface SQLConvertable
{
    public function toSQL(): string;
}
