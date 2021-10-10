<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\LowerThanOrEqualsFilter;

class DummyLowerThanOrEqualsFilter extends LowerThanOrEqualsFilter
{
    use DummyGatherableFilterTrait;
}
