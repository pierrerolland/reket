<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Internal;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Source;

class DoubleExternalField extends ExternalField
{
    private ExternalField $inner;

    private Source $source;

    public function __construct(ExternalField $inner, Source $source)
    {
        $this->inner = $inner;
        $this->source = $source;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getConnector(): Connector
    {
        return new DoubleConnector($this->source, $this->inner->getConnector());
    }

    public function getBaseField(): Field
    {
        return $this->inner->getBaseField();
    }

    public function getAlias(): ?string
    {
        return $this->inner->getAlias();
    }
}
