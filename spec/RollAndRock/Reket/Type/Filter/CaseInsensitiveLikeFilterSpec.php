<?php

namespace spec\RollAndRock\Reket\Type\Filter;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Filter\CaseInsensitiveLikeFilter;
use RollAndRock\Reket\Type\Gatherable;
use spec\RollAndRock\Reket\Type\Implementation\DummyCaseInsensitiveLikeFilter;

class CaseInsensitiveLikeFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyCaseInsensitiveLikeFilter::class);
        $this->beConstructedWith('');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CaseInsensitiveLikeFilter::class);
    }

    function its_to_sql_returns_parameterized_query_string(Gatherable $toFilter)
    {
        $this->beConstructedWith('param');

        $this->setToFilter($toFilter);
        $toFilter->toUnaliasedSQL()->willReturn('source.field');

        $this->toSQL()->shouldEqual('source.field ILIKE ?');
        $this->getParameters()->shouldEqual(['param']);
    }
}
