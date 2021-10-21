<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Gatherable;

class AggregatorsToSQLTransformer
{
    /**
     * @param Gatherable[] $aggregators
     */
    public static function transform(array $aggregators): string
    {
        if (count($aggregators) === 0) {
            return '';
        }

        return sprintf(
            ' GROUP BY %s',
            implode(', ', array_map(fn (Gatherable $aggregator) => $aggregator->toSQL(), $aggregators))
        );
    }
}
