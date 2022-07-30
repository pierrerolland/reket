<?php

namespace spec\RollAndRock\Reket\Type\Filter;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Filter\InCollectionFilter;
use RollAndRock\Reket\Type\Gatherable;
use spec\RollAndRock\Reket\Type\Implementation\DummyInCollectionFilter;

class InCollectionFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyInCollectionFilter::class);
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InCollectionFilter::class);
    }

    function its_to_sql_returns_parameterized_query_string(Gatherable $toFilter)
    {
        $this->beConstructedWith([22, 29, 35, 44, 56]);

        $this->setToFilter($toFilter);
        $toFilter->toUnaliasedSQL()->willReturn('source.field');

        $this->toSQL()->shouldEqual('source.field IN (?, ?, ?, ?, ?)');
        $this->getParameters()->shouldEqual([22, 29, 35, 44, 56]);
    }
}
