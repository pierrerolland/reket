<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter\Connecting;

use RollAndRock\Reket\Type\Gatherable;

interface ConnectingFilter
{
    public function attaching(): Gatherable;
}
