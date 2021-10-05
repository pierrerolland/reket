<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Field
{
    public function getName(): string;

    public function getSource(): Source;
}
