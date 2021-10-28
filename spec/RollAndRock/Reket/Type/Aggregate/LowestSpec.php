<?php

namespace spec\RollAndRock\Reket\Type\Aggregate;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Aggregate\Lowest;

class LowestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Lowest::class);
    }

    function its_to_sql_returns_string()
    {
        $this->toSQL()->shouldEqual('MIN(1)');
    }
}
