<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\LikeFilter;

class DummyLikeFilter extends LikeFilter
{
    use DummyGatherableFilterTrait;
}
