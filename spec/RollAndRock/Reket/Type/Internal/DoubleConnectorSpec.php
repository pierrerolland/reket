<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Internal;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Internal\DoubleConnector;
use RollAndRock\Reket\Type\Source;

class DoubleConnectorSpec extends ObjectBehavior
{
    public function let(Connector $connector, Source $source)
    {
        $this->beConstructedWith($source, $connector);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(DoubleConnector::class);
    }

    public function its_get_optional_returns_inner_get_optional(Connector $connector)
    {
        $connector->isOptional()->willReturn(true);

        $this->isOptional()->shouldReturn(true);
    }

    public function its_attach_to_returns_inner_attach_to(Connector $connector, Source $connectorSource)
    {
        $connector->attachTo()->willReturn($connectorSource);

        $this->attachTo()->shouldReturn($connectorSource);
    }

    public function its_get_connecting_alias_returns_source_connecting_alias(Source $source)
    {
        $source->getConnectingAlias()->willReturn('alias');

        $this->getConnectingAlias()->shouldReturn('alias');
    }
}
