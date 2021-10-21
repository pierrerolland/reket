<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\AggregatorsToSQLTransformer;
use RollAndRock\Reket\Type\Gatherable;

class AggregatorsToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AggregatorsToSQLTransformer::class);
    }

    function its_transform_returns_group_by_string(Gatherable $gatherable1, Gatherable $gatherable2)
    {
        $gatherable1->toSQL()->willReturn('source1.field1');
        $gatherable2->toSQL()->willReturn('source2.field2');

        $this->transform([$gatherable1, $gatherable2])->shouldReturn(' GROUP BY source1.field1, source2.field2');
    }

    function its_transform_with_empty_aggregators_returns_empty_string()
    {
        $this->transform([])->shouldReturn('');
    }
}
