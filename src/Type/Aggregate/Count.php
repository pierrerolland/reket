<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Aggregate;

class Count extends Aggregate
{
    protected function action(): string
    {
        return 'COUNT';
    }
}
