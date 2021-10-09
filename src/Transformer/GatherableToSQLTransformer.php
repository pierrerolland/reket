<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Gatherable;

class GatherableToSQLTransformer
{
    public static function transform(array $gatherables): string
    {
        return sprintf(
            'SELECT %s',
            implode(
                ', ',
                array_map(
                    fn (Gatherable $gatherable) => $gatherable->toSQL(),
                    $gatherables
                )
            )
        );
    }
}
