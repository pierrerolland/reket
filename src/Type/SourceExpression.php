<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class SourceExpression extends Expression implements Source
{
    abstract public function getName(): string;
}
