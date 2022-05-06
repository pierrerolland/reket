<?php

namespace spec\RollAndRock\Reket\Type\Aggregate;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Aggregate\Aggregate;
use RollAndRock\Reket\Type\Gatherable;
use spec\RollAndRock\Reket\Type\Implementation\DummyAggregate;

class AggregateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyAggregate::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Aggregate::class);
    }

    function its_to_sql_returns_string()
    {
        $this->setAction('ACTION');

        $this->toSQL()->shouldEqual('ACTION(1)');
    }

    function its_to_sql_returns_aliased_string()
    {
        $this->beConstructedWith('actioned_field');
        $this->setAction('ACTION');

        $this->toSQL()->shouldEqual('ACTION(1) AS actioned_field');
    }

    function its_to_sql_with_gatherable_returns_string(Gatherable $gatherable)
    {
        $this->beConstructedWith(null, $gatherable);
        $gatherable->toSQL()->willReturn('source.field');
        $this->setAction('ACTION');

        $this->toSQL()->shouldEqual('ACTION(source.field)');
    }

    function its_to_sql_with_gatherable_returns_aliased_string(Gatherable $gatherable)
    {
        $this->beConstructedWith('actioned_field', $gatherable);
        $gatherable->toSQL()->willReturn('source.field');
        $this->setAction('ACTION');

        $this->toSQL()->shouldEqual('ACTION(source.field) AS actioned_field');
    }

    function its_operate_on_returns_gatherable(Gatherable $gatherable)
    {
        $this->beConstructedWith(null, $gatherable);

        $this->operateOn()->shouldEqual($gatherable);
    }
}
