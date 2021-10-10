<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\LowerThanFilter;

class DummyLowerThanFilter extends LowerThanFilter
{
    use DummyGatherableFilterTrait;
}
