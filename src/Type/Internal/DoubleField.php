<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Internal;

use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Source;

class DoubleField extends Field
{
    private Field $inner;

    private Source $source;

    public function __construct(Field $inner, Source $source)
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
        return $this->inner->getName();
    }

    public function getAlias(): ?string
    {
        return $this->inner->getAlias();
    }
}
