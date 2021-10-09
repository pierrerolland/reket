<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface Gatherable extends SQLConvertable
{
    public function getSource(): Source;
}
