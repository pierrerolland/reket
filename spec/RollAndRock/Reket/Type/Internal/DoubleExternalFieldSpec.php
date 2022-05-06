<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Internal;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Internal\DoubleExternalField;
use RollAndRock\Reket\Type\Source;

class DoubleExternalFieldSpec extends ObjectBehavior
{
    public function let(ExternalField $externalField, Source $source)
    {
        $this->beConstructedWith($externalField, $source);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(DoubleExternalField::class);
    }

    function its_get_source_returns_constructor_source(Source $source)
    {
        $this->getSource()->shouldReturn($source);
    }

    function its_get_connector_returns_constructor_field_connector(ExternalField $externalField, Connector $connector)
    {
        $externalField->getConnector()->willReturn($connector);

        $this->getConnector()->shouldReturn($connector);
    }

    function its_get_base_field_returns_constructor_field_base_field(ExternalField $externalField, Field $field)
    {
        $externalField->getBaseField()->willReturn($field);

        $this->getBaseField()->shouldReturn($field);
    }

    function its_get_alias_returns_constructor_field_alias(ExternalField $externalField)
    {
        $externalField->getAlias()->willReturn('alias');

        $this->getAlias()->shouldReturn('alias');
    }
}
