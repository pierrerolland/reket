<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Sortable;

class SortablesToSQLTransformer
{
    /**
     * @param Sortable[] $sortables
     */
    public static function transform(array $sortables): string
    {
        if (count($sortables) === 0) {
            return '';
        }

        return sprintf(
            ' ORDER BY %s',
            implode(
                ', ',
                array_map(
                    fn (Sortable $sortable) => sprintf('%s %s', $sortable->gatherable->toSQL(), $sortable->direction),
                    $sortables
                )
            )
        );
    }
}
