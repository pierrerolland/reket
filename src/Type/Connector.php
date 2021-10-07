<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Transformer\PascalCaseToSnakeCaseTransformer;

abstract class Connector implements Connectable
{
    private ExternalField $attachUsing;

    public function __construct(ExternalField $attachUsing)
    {
        $this->attachUsing = $attachUsing;
    }

    abstract public function isOptional(): bool;

    public function attachUsing(): ExternalField
    {
        return $this->attachUsing;
    }

    abstract public function attachTo(): Gatherable;

    public function getConnectingAlias(): string
    {
        return sprintf(
            '_%s',
            str_replace(
                '_connector',
                '',
                PascalCaseToSnakeCaseTransformer::transform(basename(str_replace('\\', '/', static::class)))
            )
        );
    }
}
