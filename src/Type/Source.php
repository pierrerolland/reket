<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Source extends Connectable
{
    public function getName(): string;
}
