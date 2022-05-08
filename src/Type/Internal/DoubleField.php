<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Internal;

use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\FieldGatherable;
use RollAndRock\Reket\Type\Source;

class DoubleField extends Field
{
    private FieldGatherable $inner;

    private Source $source;

    public function __construct(FieldGatherable $inner, Source $source)
    {
        $this->inner = $inner;
        $this->source = $source;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getName(): string
    {
        if ($this->inner instanceof Field) {
            return $this->inner->getName();
        }

        if ($this->inner->getAlias() !== null) {
            return $this->inner->getAlias();
        }

        if ($this->inner instanceof ExternalField) {
            return $this->inner->getBaseField()->getName();
        }

        return '';
    }

    public function getAlias(): ?string
    {
        return $this->inner->getAlias();
    }
}
