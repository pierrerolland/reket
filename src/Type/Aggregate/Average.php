<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Aggregate;

class Average extends Aggregate
{
    protected function action(): string
    {
        return 'AVG';
    }
}
