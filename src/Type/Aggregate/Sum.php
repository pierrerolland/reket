<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Aggregate;

class Sum extends Aggregate
{
    protected function action(): string
    {
        return 'SUM';
    }
}
