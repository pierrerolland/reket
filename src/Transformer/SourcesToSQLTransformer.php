<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Source;
use RollAndRock\Reket\Type\SourceExpression;

class SourcesToSQLTransformer
{
    /**
     * @param Connector[] $connectors
     */
    public static function transform(Source $source, array $connectors): string
    {
        return sprintf(
            'FROM %s%s%s',
            $source instanceof SourceExpression ? sprintf('(%s)', $source->toSQL()) : $source->getName(),
            $source->getConnectingAlias() ? sprintf(' %s', $source->getConnectingAlias()) : '',
            count($connectors) === 0
                ? ''
                : sprintf(
                ' %s',
                implode(
                    ' ',
                    array_map(
                        fn(Connector $connector) => $connector->toSQL(),
                        $connectors
                    )
                ))
        );
    }
}
