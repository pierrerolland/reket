<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\SortablesToSQLTransformer;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\GatherableExpression;
use RollAndRock\Reket\Type\Sortable;
use RollAndRock\Reket\Type\SortingDirection;
use spec\RollAndRock\Reket\Type\Implementation\DummyGatherableExpression;

class SortablesToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SortablesToSQLTransformer::class);
    }

    function its_transform_returns_where_string(Sortable $sortable, Gatherable $gatherable)
    {
        $gatherable->toSQL()->willReturn('source.field');
        $sortable->gatherable = $gatherable;
        $sortable->direction = SortingDirection::ASCENDING_ORDER;

        $this->transform([$sortable], [])->shouldEqual(' ORDER BY source.field ASC');
    }

    function its_transform_with_several_sortables_returns_where_string(
        Sortable $sortable1,
        Gatherable $gatherable1,
        Sortable $sortable2,
        Gatherable $gatherable2,
        Sortable $sortable3,
        GatherableExpression $gatherableExpression1,
        Sortable $sortable4,
        DummyGatherableExpression $gatherableExpression2
    ) {
        $gatherable1->toSQL()->willReturn('source1.field1');
        $sortable1->gatherable = $gatherable1;
        $sortable1->direction = SortingDirection::ASCENDING_ORDER;
        $gatherable2->toSQL()->willReturn('source2.field2');
        $sortable2->gatherable = $gatherable2;
        $sortable2->direction = SortingDirection::DESCENDING_ORDER;
        $gatherableExpression1->getAlias()->willReturn('expression1');
        $sortable3->gatherable = $gatherableExpression1;
        $sortable3->direction = SortingDirection::ASCENDING_ORDER;
        $gatherableExpression2->toSQL()->willReturn('source3.field3');
        $sortable4->gatherable = $gatherableExpression2;
        $sortable4->direction = SortingDirection::ASCENDING_ORDER;

        $this->transform(
            [$sortable1, $sortable2, $sortable3, $sortable4],
            [$gatherableExpression1]
        )->shouldEqual(' ORDER BY source1.field1 ASC, source2.field2 DESC, expression1 ASC, source3.field3 ASC');
    }

    function its_transform_with_no_sortable_returns_where_string()
    {
        $this->transform([], [])->shouldEqual('');
    }
}
