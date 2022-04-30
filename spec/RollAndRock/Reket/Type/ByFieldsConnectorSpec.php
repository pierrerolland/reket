<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RollAndRock\Reket\Type\ByFieldsConnector;
use RollAndRock\Reket\Type\ConnectingField;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Filter\Connecting\FieldsConnectingFilter;
use RollAndRock\Reket\Type\Source;
use spec\RollAndRock\Reket\Type\Implementation\DummyByFieldsConnector;

class ByFieldsConnectorSpec extends ObjectBehavior
{
    function let(Field $attachingField, ConnectingField $attachToField)
    {
        $this->beAnInstanceOf(DummyByFieldsConnector::class);
        $this->beConstructedWith($attachingField, $attachToField);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ByFieldsConnector::class);
        $this->shouldBeAnInstanceOf(Connector::class);
    }

    function its_attach_to_returns_attach_to_field_source(ConnectingField $attachToField, Source $source)
    {
        $attachToField->getSource()->willReturn($source);
        $attachToField->useWithConnector($this)->shouldBeCalledOnce();

        $this->attachTo()->shouldReturn($source);
    }
}
