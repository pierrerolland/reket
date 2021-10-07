<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Gatherable
{
    public function getGatherSQL(): string;

    public function getSource(): Source;
}
