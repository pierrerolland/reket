<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Internal;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\ConnectingField;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Filter\Connecting\FieldsConnectingFilter;
use RollAndRock\Reket\Type\Filter\EqualsFilter;
use RollAndRock\Reket\Type\Internal\DoubleConnector;
use RollAndRock\Reket\Type\Internal\DoubleField;
use RollAndRock\Reket\Type\Source;

class DoubleConnectorSpec extends ObjectBehavior
{
    public function let(Connector $connector, Source $source)
    {
        $connector->getFilters()->willReturn([]);
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

    public function its_get_connecting_alias_returns_source_connecting_alias(Connector $connector)
    {
        $connector->getConnectingAlias()->willReturn('alias');

        $this->getConnectingAlias()->shouldReturn('alias');
    }

    public function its_get_filters_returns_doubled_connecting_filters(
        Connector $connector,
        Source $source,
        FieldsConnectingFilter $connectingFilter,
        EqualsFilter $otherFilter,
        Field $attaching,
        ConnectingField $attachTo
    ) {
        $connectingFilter->attaching()->willReturn($attaching);
        $connectingFilter->attachTo()->willReturn($attachTo);
        $connector->getFilters()->willReturn([$connectingFilter, $otherFilter]);

        $this->getFilters()->shouldHaveCount(2);
        $this->getFilters()[1]->shouldBe($otherFilter);
        $this->getFilters()[0]->shouldBeAnInstanceOf(FieldsConnectingFilter::class);
        $this->getFilters()[0]->attaching()->shouldBeAnInstanceOf(DoubleField::class);
        $this->getFilters()[0]->attaching()->getSource()->shouldBe($source);
        $this->getFilters()[0]->attachTo()->shouldBe($attachTo);
    }
}
