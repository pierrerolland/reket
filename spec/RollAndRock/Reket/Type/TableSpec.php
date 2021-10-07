<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Source;
use RollAndRock\Reket\Type\Table;
use spec\RollAndRock\Reket\Type\Implementation\DummyTable;

class TableSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyTable::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Table::class);
        $this->shouldBeAnInstanceOf(Source::class);
    }

    function its_get_connecting_alias_returns_null()
    {
        $this->getConnectingAlias()->shouldBeNull();
    }
}
