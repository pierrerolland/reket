<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter;

abstract class CaseInsensitiveLikeFilter extends LikeFilter
{
    protected function getOperator(): string
    {
        return 'ILIKE';
    }
}
