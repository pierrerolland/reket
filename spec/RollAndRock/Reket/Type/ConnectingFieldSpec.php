<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Exception\ConnectingFieldWithoutConnectorException;
use RollAndRock\Reket\Type\ConnectingField;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Source;
use spec\RollAndRock\Reket\Type\Implementation\DummyConnectingField;

class ConnectingFieldSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyConnectingField::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConnectingField::class);
        $this->shouldBeAnInstanceOf(Field::class);
        $this->shouldBeAnInstanceOf(Gatherable::class);
    }

    function its_to_sql_returns_parent_sql_if_no_connector(Source $source)
    {
        $source->getName()->willReturn('source');
        $source->getConnectingAlias()->willReturn(null);

        $this->setName('connecting_field');
        $this->setSource($source);

        $this->toSQL()->shouldReturn('source.connecting_field');
    }

    function its_to_sql_returns_connector_related_sql(Connector $connector, Source $connectorAttachment)
    {
        $connector->getConnectingAlias()->willReturn('target');
        $this->useWithConnector($connector);
        $this->setName('connecting_field');

        $this->toSQL()->shouldReturn('target.connecting_field');
    }

    function its_to_sql_returns_connector_aliased_sql(Connector $connector, Source $connectorAttachment)
    {
        $connector->getConnectingAlias()->willReturn('target');
        $this->useWithConnector($connector);
        $this->setName('connecting_field');
        $this->setAlias('alias');

        $this->toSQL()->shouldReturn('target.connecting_field AS alias');
    }
}
