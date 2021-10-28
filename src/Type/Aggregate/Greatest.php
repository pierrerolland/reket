<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Aggregate;

class Greatest extends Aggregate
{
    protected function action(): string
    {
        return 'MAX';
    }
}
