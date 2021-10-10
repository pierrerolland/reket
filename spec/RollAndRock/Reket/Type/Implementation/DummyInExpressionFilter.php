<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\InExpressionFilter;

class DummyInExpressionFilter extends InExpressionFilter
{
    use DummyGatherableFilterTrait;
}
