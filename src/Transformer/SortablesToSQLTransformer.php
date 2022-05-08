<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\GatherableExpression;
use RollAndRock\Reket\Type\Sortable;

class SortablesToSQLTransformer
{
    /**
     * @param Sortable[] $sortables
     */
    public static function transform(array $sortables, array $gatherables): string
    {
        if (count($sortables) === 0) {
            return '';
        }

        return sprintf(
            ' ORDER BY %s',
            implode(
                ', ',
                array_map(
                    fn (Sortable $sortable) => sprintf('%s %s', self::getSortableSQL($sortable, $gatherables), $sortable->direction),
                    $sortables
                )
            )
        );
    }

    /**
     * @param Gatherable[] $gatherables
     */
    private static function getSortableSQL(Sortable $sortable, array $gatherables): string
    {
        if (!$sortable->gatherable instanceof GatherableExpression) {
            return $sortable->gatherable->toSQL();
        }

        foreach ($gatherables as $gatherable) {
            if (get_class($gatherable) === get_class($sortable->gatherable)) {
                return $sortable->gatherable->getAlias();
            }
        }

        return $sortable->gatherable->toSQL();
    }
}
