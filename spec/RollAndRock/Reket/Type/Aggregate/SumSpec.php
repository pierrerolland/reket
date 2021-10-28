<?php

namespace spec\RollAndRock\Reket\Type\Aggregate;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Aggregate\Sum;

class SumSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Sum::class);
    }

    function its_to_sql_returns_string()
    {
        $this->toSQL()->shouldEqual('SUM(1)');
    }
}
