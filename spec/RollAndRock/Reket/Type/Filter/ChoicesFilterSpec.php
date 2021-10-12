<?php

namespace spec\RollAndRock\Reket\Type\Filter;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Filter\ChoicesFilter;
use RollAndRock\Reket\Type\Filter\Filter;
use spec\RollAndRock\Reket\Type\Implementation\DummyChoicesFilter;

class ChoicesFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyChoicesFilter::class);
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ChoicesFilter::class);
    }

    function its_to_sql_returns_string(Filter $filter1, Filter $filter2, Filter $filter3)
    {
        $this->beConstructedWith([$filter1, $filter2, $filter3]);

        $filter1->toSQL()->willReturn('condition1');
        $filter2->toSQL()->willReturn('condition2');
        $filter3->toSQL()->willReturn('condition3');
        $this->setChoices([$filter1, $filter2, $filter3]);

        $this->toSQL()->shouldEqual('(condition1) OR (condition2) OR (condition3)');
    }
}
