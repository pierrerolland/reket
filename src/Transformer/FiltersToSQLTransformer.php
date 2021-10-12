<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Filter\Filter;

class FiltersToSQLTransformer
{
    /**
     * @param Filter[] $filters
     */
    public static function transform(array $filters): string
    {
        if (count($filters) === 0) {
            return '';
        }

        return sprintf(
            ' WHERE (%s)',
            implode(') AND (', array_map(fn (Filter $filter) => $filter->toSQL(), $filters))
        );
    }
}
