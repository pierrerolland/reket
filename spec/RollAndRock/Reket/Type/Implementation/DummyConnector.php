<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Gatherable;

class DummyConnector extends Connector
{
    private Gatherable $attachTo;

    public function isOptional(): bool
    {
        return true;
    }

    public function attachTo(): Gatherable
    {
        return $this->attachTo;
    }

    public function setAttachTo(Gatherable $attachTo): void
    {
        $this->attachTo = $attachTo;
    }
}
