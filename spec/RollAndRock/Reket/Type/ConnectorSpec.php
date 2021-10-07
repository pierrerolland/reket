<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Connectable;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use spec\RollAndRock\Reket\Type\Implementation\DummyConnector;

class ConnectorSpec extends ObjectBehavior
{
    function let(ExternalField $attachUsing)
    {
        $this->beAnInstanceOf(DummyConnector::class);
        $this->beConstructedWith($attachUsing);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Connector::class);
        $this->shouldBeAnInstanceOf(Connectable::class);
    }

    function its_get_connecting_alias_returns_string()
    {
        $this->getConnectingAlias()->shouldEqual('_dummy');
    }

    function its_get_attach_using_returns_external_field(ExternalField $attachUsing)
    {
        $this->attachUsing()->shouldEqual($attachUsing);
    }
}
