<?php

namespace spec\RollAndRock\Reket\Type\Filter;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Filter\BetweenFilter;
use RollAndRock\Reket\Type\Gatherable;
use spec\RollAndRock\Reket\Type\Implementation\DummyBetweenFilter;

class BetweenFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyBetweenFilter::class);
        $this->beConstructedWith(null, null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BetweenFilter::class);
    }

    function its_to_sql_returns_parameterized_query_string(Gatherable $toFilter)
    {
        $this->beConstructedWith(29, 35);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');

        $this->toSQL()->shouldEqual('source.field BETWEEN ? AND ?');
        $this->getParameters()->shouldEqual([29, 35]);
    }

    function its_to_sql_returns_second_half_parameterized_query_string(Gatherable $toFilter, Gatherable $start)
    {
        $this->beConstructedWith($start, 35);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');
        $start->toSQL()->willReturn('target.start');

        $this->toSQL()->shouldEqual('source.field BETWEEN target.start AND ?');
        $this->getParameters()->shouldEqual([35]);
    }

    function its_to_sql_returns_first_half_parameterized_query_string(Gatherable $toFilter, Gatherable $end)
    {
        $this->beConstructedWith(29, $end);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');
        $end->toSQL()->willReturn('target.end');

        $this->toSQL()->shouldEqual('source.field BETWEEN ? AND target.end');
        $this->getParameters()->shouldEqual([29]);
    }

    function its_to_sql_returns_non_parameterized_query_string(Gatherable $toFilter, Gatherable $start, Gatherable $end)
    {
        $this->beConstructedWith($start, $end);

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');
        $start->toSQL()->willReturn('target.start');
        $end->toSQL()->willReturn('target.end');

        $this->toSQL()->shouldEqual('source.field BETWEEN target.start AND target.end');
        $this->getParameters()->shouldEqual([]);
    }
}
