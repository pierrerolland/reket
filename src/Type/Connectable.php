<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Connectable
{
    public function getConnectingAlias(): ?string;
}
