<?php

namespace spec\RollAndRock\Reket\Type\Aggregate;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Aggregate\Greatest;

class GreatestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Greatest::class);
    }

    function its_to_sql_returns_string()
    {
        $this->toSQL()->shouldEqual('MAX(1)');
    }
}
