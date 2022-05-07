<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Internal;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Source;

class DoubleConnector extends Connector
{
    private Source $source;

    private Connector $inner;

    public function __construct(Source $source, Connector $inner)
    {
        $this->source = $source;
        $this->inner = $inner;
    }

    public function isOptional(): bool
    {
        return $this->inner->isOptional();
    }

    public function attachTo(): Source
    {
        return $this->inner->attachTo();
    }

    public function getConnectingAlias(): string
    {
        return $this->source->getConnectingAlias();
    }
}
