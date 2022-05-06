<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Json;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\GatherableExpression;
use RollAndRock\Reket\Type\Json\JsonObject;

class JsonObjectSpec extends ObjectBehavior
{
    function let(Field $field, ExternalField $externalField, GatherableExpression $expression, Gatherable $gatherable)
    {
        $this->beConstructedWith([
            $field,
            $externalField,
            $expression,
            $gatherable
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(JsonObject::class);
    }

    function its_to_sql_returns_json_object_sql_string(
        Field $field,
        ExternalField $externalField,
        GatherableExpression $expression,
        Gatherable $gatherable,
        Field $baseField
    ) {
        $field->getAlias()->willReturn(null);
        $field->getName()->willReturn('field');
        $field->toSQL()->willReturn('source1.field');
        $baseField->getName()->willReturn('base_field');
        $externalField->getAlias()->willReturn(null);
        $externalField->getBaseField()->willReturn($baseField);
        $externalField->toSQL()->willReturn('source2.external_field');
        $expression->getAlias()->willReturn('expression');
        $expression->toSQL()->willReturn('SELECT(...)');
        $gatherable->getAlias()->willReturn(null);
        $gatherable->toSQL()->willReturn('COUNT');

        $this->toSQL()->shouldReturn("JSON_BUILD_OBJECT('field', source1.field, 'base_field', source2.external_field, 'expression', SELECT(...), 'COUNT', COUNT)");
    }

    function its_to_sql_returns_aliased_sql_string()
    {
        $this->beConstructedWith([], 'the_alias');

        $this->toSQL()->shouldReturn('JSON_BUILD_OBJECT() AS the_alias');
    }

    function its_get_sources_returns_gatherables_sources(Field $field, ExternalField $externalField)
    {
        $this->getSourcedGatherables()->shouldReturn([$field, $externalField]);
    }
}
