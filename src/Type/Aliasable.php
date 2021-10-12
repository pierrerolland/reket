<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Aliasable
{
    public function getAlias(): ?string;
}
