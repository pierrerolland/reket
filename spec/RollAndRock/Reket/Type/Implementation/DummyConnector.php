<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Source;

class DummyConnector extends Connector
{
    private Source $attachTo;

    private bool $optional;

    public function isOptional(): bool
    {
        return $this->optional;
    }

    public function setOptional(bool $optional): void
    {
        $this->optional = $optional;
    }

    public function attachTo(): Source
    {
        return $this->attachTo;
    }

    public function setAttachTo(Source $attachTo): void
    {
        $this->attachTo = $attachTo;
    }

    public function setFilters(array $filters): void
    {
        foreach ($filters as $filter) {
            $this->useFilter($filter);
        }
    }
}
