<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\GreaterThanFilter;

class DummyGreaterThanFilter extends GreaterThanFilter
{
    use DummyGatherableFilterTrait;
}
