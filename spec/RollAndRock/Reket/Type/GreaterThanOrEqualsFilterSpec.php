<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\GreaterThanOrEqualsFilter;
use spec\RollAndRock\Reket\Type\Implementation\DummyGreaterThanOrEqualsFilter;

class GreaterThanOrEqualsFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyGreaterThanOrEqualsFilter::class);
        $this->beConstructedWith(null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GreaterThanOrEqualsFilter::class);
    }

    function its_to_sql_returns_parameterized_query_string(Gatherable $toFilter)
    {
        $this->beConstructedWith(42);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');

        $this->toSQL()->shouldEqual('source.field >= ?');
        $this->getParameters()->shouldEqual([42]);
    }

    function its_to_sql_with_gatherable_returns_non_parameterized_query_string(Gatherable $toFilter, Gatherable $compareTo)
    {
        $this->beConstructedWith($compareTo);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');
        $compareTo->toSQL()->willReturn('target.compare_field');

        $this->toSQL()->shouldEqual('source.field >= target.compare_field');
        $this->getParameters()->shouldEqual([]);
    }
}
