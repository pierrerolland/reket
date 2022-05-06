<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Internal;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Internal\DoubleField;
use RollAndRock\Reket\Type\Source;

class DoubleFieldSpec extends ObjectBehavior
{
    function let(Field $field, Source $source)
    {
        $this->beConstructedWith($field, $source);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DoubleField::class);
    }

    function its_get_source_returns_constructor_source(Source $source)
    {
        $this->getSource()->shouldReturn($source);
    }

    function its_get_name_returns_constructor_field_name(Field $field)
    {
        $field->getName()->willReturn('field');

        $this->getName()->shouldReturn('field');
    }

    function its_get_alias_returns_constructor_field_name(Field $field)
    {
        $field->getAlias()->willReturn('alias');

        $this->getAlias()->shouldReturn('alias');
    }
}
