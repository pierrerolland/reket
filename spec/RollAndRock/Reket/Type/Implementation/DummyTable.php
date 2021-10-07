<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Table;

class DummyTable extends Table
{
    public function getName(): string
    {
        return 'table';
    }
}
