<?php

namespace spec\RollAndRock\Reket\Type\Filter;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Filter\Filter;
use spec\RollAndRock\Reket\Type\Implementation\DummyFilter;

class FilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyFilter::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Filter::class);
    }

    function its_get_parameters_returns_array()
    {
        $parameters = [null];

        $this->setParameters($parameters);

        $this->getParameters()->shouldEqual($parameters);
    }
}
