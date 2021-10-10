<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\BetweenFilter;

class DummyBetweenFilter extends BetweenFilter
{
    use DummyGatherableFilterTrait;
}
