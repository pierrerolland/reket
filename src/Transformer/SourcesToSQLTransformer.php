<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Source;

class SourcesToSQLTransformer
{
    /**
     * @param Connector[] $connectors
     */
    public static function transform(Source $source, array $connectors): string
    {
        return sprintf(
            'FROM %s%s',
            $source->getName(),
            count($connectors) === 0
                ? ''
                : sprintf(
                    ' %s',
                    implode(
                        ' ',
                        array_map(
                            fn (Connector $connector) => $connector->toSQL(),
                            $connectors
                        )
                    ))
        );
    }
}
