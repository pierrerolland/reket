<?php

namespace spec\RollAndRock\Reket\Type\Aggregate;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Aggregate\Average;

class AverageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Average::class);
    }

    function its_to_sql_returns_string()
    {
        $this->toSQL()->shouldEqual('AVG(1)');
    }
}
