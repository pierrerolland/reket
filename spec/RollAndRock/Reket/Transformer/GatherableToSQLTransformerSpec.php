<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\GatherableToSQLTransformer;
use RollAndRock\Reket\Type\Gatherable;

class GatherableToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GatherableToSQLTransformer::class);
    }

    function its_transform_returns_select_string(Gatherable $gatherable1, Gatherable $gatherable2)
    {
        $gatherable1->toSQL()->willReturn('source1.field1');
        $gatherable2->toSQL()->willReturn('source2.field2');

        $this->transform([$gatherable1, $gatherable2])->shouldReturn('SELECT source1.field1, source2.field2');
    }
}
