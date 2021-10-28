<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Aggregate;

class JsonArray extends Aggregate
{
    protected function action(): string
    {
        return 'JSON_AGG';
    }
}
