<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\CaseInsensitiveLikeFilter;

class DummyCaseInsensitiveLikeFilter extends CaseInsensitiveLikeFilter
{
    use DummyGatherableFilterTrait;
}
