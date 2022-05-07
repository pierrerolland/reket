<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Gatherable extends Aliasable, SQLConvertable
{
    public function toUnaliasedSQL(): string;
}
