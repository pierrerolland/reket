<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\Connector;

class ConnectorToSQLTransformer
{
    public static function transform(Connector $connector): string
    {
        $join = sprintf('%sJOIN', $connector->isOptional() ? 'LEFT ' : '');

        return sprintf(
            '%s %s %s ON %s = %s',
            $join,
            $connector->attachUsing()->getSource()->getName(),
            $connector->getConnectingAlias() ?? '',
            $connector->attachUsing()->getGatherSQL(),
            $connector->attachTo()->getGatherSQL()
        );
    }
}
