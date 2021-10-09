<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\EqualsFilter;
use RollAndRock\Reket\Type\Gatherable;
use spec\RollAndRock\Reket\Type\Implementation\DummyEqualsFilter;

class EqualsFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyEqualsFilter::class);
        $this->beConstructedWith(null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EqualsFilter::class);
    }

    function its_to_sql_returns_null_specific_string(Gatherable $toFilter)
    {
        $toFilter->toSQL()->willReturn('source.field');
        $this->setToFilter($toFilter);

        $this->toSQL()->shouldEqual('source.field IS NULL');
    }

    function its_to_sql_returns_parameterized_query_string(Gatherable $toFilter)
    {
        $this->beConstructedWith(42);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');

        $this->toSQL()->shouldEqual('source.field = ?');
        $this->getParameters()->shouldEqual([42]);
    }

    function its_to_sql_with_gatherable_returns_non_parameterized_query_string(Gatherable $toFilter, Gatherable $compareTo)
    {
        $this->beConstructedWith($compareTo);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');
        $compareTo->toSQL()->willReturn('target.compare_field');

        $this->toSQL()->shouldEqual('source.field = target.compare_field');
        $this->getParameters()->shouldEqual([]);
    }
}
