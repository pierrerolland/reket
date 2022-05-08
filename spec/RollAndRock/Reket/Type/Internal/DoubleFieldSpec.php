<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Internal;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\FieldGatherable;
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

    function its_get_name_returns_constructor_external_field_alias(ExternalField $field, Source $source)
    {
        $this->beConstructedWith($field, $source);

        $field->getAlias()->willReturn('alias');

        $this->getName()->shouldReturn('alias');
    }

    function its_get_name_returns_constructor_external_field_base_field_name(ExternalField $field, Field $baseField, Source $source)
    {
        $baseField->getName()->willReturn('name');
        $field->getAlias()->willReturn(null);
        $field->getBaseField()->willReturn($baseField);
        $this->beConstructedWith($field, $source);

        $this->getName()->shouldReturn('name');
    }

    function its_get_name_returns_empty_string_if_no_candidate(FieldGatherable $gatherable, Source $source)
    {
        $this->beConstructedWith($gatherable, $source);
        $gatherable->getAlias()->willReturn(null);

        $this->getName()->shouldReturn('');
    }

    function its_get_alias_returns_constructor_field_name(Field $field)
    {
        $field->getAlias()->willReturn('alias');

        $this->getAlias()->shouldReturn('alias');
    }
}
