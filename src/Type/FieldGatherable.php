<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface FieldGatherable extends Gatherable
{
    public function getSource(): Source;
}
