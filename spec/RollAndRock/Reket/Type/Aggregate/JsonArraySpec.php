<?php

namespace spec\RollAndRock\Reket\Type\Aggregate;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Aggregate\JsonArray;

class JsonArraySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonArray::class);
    }

    function its_to_sql_returns_string()
    {
        $this->toSQL()->shouldEqual('JSON_AGG(1)');
    }
}
