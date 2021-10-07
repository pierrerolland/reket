<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Transformer;

class PascalCaseToSnakeCaseTransformer
{
    public static function transform(string $source): string
    {
        return strtolower(preg_replace('/(\G(?!^)|\b[a-zA-Z][a-z]*)([A-Z][a-z]*|\d+)/', '\1_\2', $source));
    }
}
