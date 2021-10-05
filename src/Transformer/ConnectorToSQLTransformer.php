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
            '%s %s ON %s.%s = %s.%s',
            $join,
            $connector->from()->getSource()->getName(),
            $connector->from()->getSource()->getName(),
            $connector->from()->getName(),
            $connector->to()->getSource()->getName(),
            $connector->to()->getName()
        );
    }
}
