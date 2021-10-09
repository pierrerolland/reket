<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Transformer\PascalCaseToSnakeCaseTransformer;

abstract class Connector implements Connectable, SQLConvertable
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

    public function toSQL(): string
    {
        $join = sprintf('%sJOIN', $this->isOptional() ? 'LEFT ' : '');

        return sprintf(
            '%s %s %s ON %s = %s',
            $join,
            $this->attachUsing()->getSource()->getName(),
            $this->getConnectingAlias() ?? '',
            $this->attachUsing()->toSQL(),
            $this->attachTo()->toSQL()
        );
    }
}
