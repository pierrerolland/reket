<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\FiltersToSQLTransformer;
use RollAndRock\Reket\Type\Filter\Filter;

class FiltersToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FiltersToSQLTransformer::class);
    }

    function its_transform_with_where_context_returns_where_string(Filter $filter)
    {
        $filter->toSQL()->willReturn('condition');

        $this->transform([$filter], 'WHERE')->shouldEqual(' WHERE (condition)');
    }

    function its_transform_with_where_context_returns_where_with_ands_string(Filter $filter1, Filter $filter2, Filter $filter3)
    {
        $filter1->toSQL()->willReturn('condition1');
        $filter2->toSQL()->willReturn('condition2');
        $filter3->toSQL()->willReturn('condition3');

        $this->transform([$filter1, $filter2, $filter3], 'WHERE')->shouldEqual(' WHERE (condition1) AND (condition2) AND (condition3)');
    }

    function its_transform_with_join_context_returns_where_string(Filter $filter)
    {
        $filter->toSQL()->willReturn('condition');

        $this->transform([$filter], 'JOIN')->shouldEqual(' ON (condition)');
    }

    function its_transform_with_join_context_returns_where_with_ands_string(Filter $filter1, Filter $filter2, Filter $filter3)
    {
        $filter1->toSQL()->willReturn('condition1');
        $filter2->toSQL()->willReturn('condition2');
        $filter3->toSQL()->willReturn('condition3');

        $this->transform([$filter1, $filter2, $filter3], 'JOIN')->shouldEqual(' ON (condition1) AND (condition2) AND (condition3)');
    }

    function its_transform_returns_empty_string()
    {
        $this->transform([], 'WHERE')->shouldEqual('');
    }
}
