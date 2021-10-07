<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

abstract class Table implements Source
{
    public function getConnectingAlias(): ?string
    {
        return null;
    }
}
