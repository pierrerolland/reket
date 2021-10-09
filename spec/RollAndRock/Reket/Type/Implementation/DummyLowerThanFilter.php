<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\LowerThanFilter;

class DummyLowerThanFilter extends LowerThanFilter
{
    use DummyFilterTrait;
}
