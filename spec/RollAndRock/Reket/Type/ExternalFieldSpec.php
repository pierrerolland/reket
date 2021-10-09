<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Source;
use spec\RollAndRock\Reket\Type\Implementation\DummyExternalField;

class ExternalFieldSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyExternalField::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExternalField::class);
        $this->shouldBeAnInstanceOf(Gatherable::class);
    }

    function its_get_source_returns_base_field_source(Field $baseField, Source $source)
    {
        $baseField->getSource()->willReturn($source);
        $this->setBaseField($baseField);

        $this->getSource()->shouldEqual($source);
    }

    function its_get_gather_sql_returns_string(Field $baseField, Connector $connector)
    {
        $baseField->getName()->willReturn('field');
        $connector->getConnectingAlias()->willReturn('alias');
        $this->setBaseField($baseField);
        $this->setConnector($connector);

        $this->toSQL()->shouldEqual('alias.field');
    }
}
