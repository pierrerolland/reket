<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\FiltersToSQLTransformer;
use RollAndRock\Reket\Type\Filter;

class FiltersToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FiltersToSQLTransformer::class);
    }

    function its_transform_returns_where_string(Filter $filter)
    {
        $filter->toSQL()->willReturn('condition');

        $this->transform([$filter])->shouldEqual('WHERE (condition)');
    }

    function its_transform_returns_where_with_ands_string(Filter $filter1, Filter $filter2, Filter $filter3)
    {
        $filter1->toSQL()->willReturn('condition1');
        $filter2->toSQL()->willReturn('condition2');
        $filter3->toSQL()->willReturn('condition3');

        $this->transform([$filter1, $filter2, $filter3])->shouldEqual('WHERE (condition1) AND (condition2) AND (condition3)');
    }
}
