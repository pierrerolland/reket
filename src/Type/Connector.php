<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Connector
{
    public function isOptional(): bool;

    public function from(): Field;

    public function to(): Field;
}
