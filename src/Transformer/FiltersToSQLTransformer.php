<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Filter\Filter;

class FiltersToSQLTransformer
{
    public const CONTEXT_WHERE = 'WHERE';

    public const CONTEXT_JOIN = 'JOIN';

    /**
     * @param Filter[] $filters
     */
    public static function transform(array $filters, string $context): string
    {
        if (count($filters) === 0) {
            return '';
        }

        return sprintf(
            ' %s (%s)',
            $context === self::CONTEXT_WHERE ? 'WHERE' : 'ON',
            implode(') AND (', array_map(fn (Filter $filter) => $filter->toSQL(), $filters))
        );
    }
}
