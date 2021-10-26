<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Aggregate\Aggregate;

class DummyAggregate extends Aggregate
{
    private string $action;

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    protected function action(): string
    {
        return $this->action;
    }
}
