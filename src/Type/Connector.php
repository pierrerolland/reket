<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Transformer\FiltersToSQLTransformer;
use RollAndRock\Reket\Transformer\PascalCaseToSnakeCaseTransformer;
use RollAndRock\Reket\Type\Filter\Filter;

abstract class Connector implements Connectable, SQLConvertable
{
    /**
     * @var Filter[]
     */
    private array $filters = [];

    public function toSQL(): string
    {
        $join = sprintf('%sJOIN', $this->isOptional() ? 'LEFT ' : '');

        return sprintf(
            '%s %s %s%s',
            $join,
            $this->attachTo()->getName(),
            $this->getConnectingAlias() ?? '',
            FiltersToSQLTransformer::transform($this->filters, FiltersToSQLTransformer::CONTEXT_JOIN)
        );
    }

    abstract public function isOptional(): bool;

    abstract public function attachTo(): Source;

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

    protected function useFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }
}
