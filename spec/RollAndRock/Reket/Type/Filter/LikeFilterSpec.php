<?php

namespace spec\RollAndRock\Reket\Type\Filter;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Filter\LikeFilter;
use RollAndRock\Reket\Type\Gatherable;
use spec\RollAndRock\Reket\Type\Implementation\DummyLikeFilter;

class LikeFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyLikeFilter::class);
        $this->beConstructedWith('');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LikeFilter::class);
    }

    function its_to_sql_returns_parameterized_query_string(Gatherable $toFilter)
    {
        $this->beConstructedWith('param');

        $this->setToFilter($toFilter);
        $toFilter->toSQL()->willReturn('source.field');

        $this->toSQL()->shouldEqual('source.field LIKE ?');
        $this->getParameters()->shouldEqual(['param']);
    }
}
