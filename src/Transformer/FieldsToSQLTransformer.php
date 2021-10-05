<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;

class FieldsToSQLTransformer
{
    public static function transform(array $fields): string
    {
        return sprintf(
            'SELECT %s',
            implode(
                ', ',
                array_map(
                    fn (Field $field) => sprintf('%s.%s', $field->getSource(), $field->getName()),
                    array_map(
                        fn ($field) => $field instanceof ExternalField ? $field->getBaseField() : $field,
                        $fields
                    )
                )
            )
        );
    }
}
