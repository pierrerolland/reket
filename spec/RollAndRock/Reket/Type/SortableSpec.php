<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Sortable;
use RollAndRock\Reket\Type\SortingDirection;

class SortableSpec extends ObjectBehavior
{
    function let(Gatherable $gatherable)
    {
        $this->beConstructedWith($gatherable, '');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Sortable::class);
    }

    function its_create_returns_sortable(Gatherable $gatherable)
    {
        $direction = SortingDirection::ASCENDING_ORDER;

        $result = $this::create($gatherable, $direction);
        $result->shouldBeAnInstanceOf(Sortable::class);
        $result->direction->shouldEqual($direction);
        $result->gatherable->shouldEqual($gatherable);
    }
}
