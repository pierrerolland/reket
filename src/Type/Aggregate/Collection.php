<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Aggregate;

class Collection extends Aggregate
{
    protected function action(): string
    {
        return 'ARRAY_AGG';
    }
}
