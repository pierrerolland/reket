<?php

namespace spec\RollAndRock\Reket\Type\Aggregate;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Aggregate\Count;

class CountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Count::class);
    }

    function its_to_sql_returns_string()
    {
        $this->toSQL()->shouldEqual('COUNT(1)');
    }
}
