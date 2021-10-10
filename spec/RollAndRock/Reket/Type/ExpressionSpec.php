<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Exception\SourceNotFoundInExpressionException;
use RollAndRock\Reket\Exception\TooManySourcesInExpressionException;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Expression;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Source;
use spec\RollAndRock\Reket\Type\Implementation\DummyExpression;

class ExpressionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyExpression::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Expression::class);
    }

    function its_to_sql_returns_string_with_accurate_source(Source $source, Field $field)
    {
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source');
    }

    function its_to_sql_with_gatherables_with_same_source_returns_string_with_accurate_source(Source $source, Field $field1, Field $field2)
    {
        $source->getName()->willReturn('source');
        $field1->toSQL()->willReturn('source.field1');
        $field2->toSQL()->willReturn('source.field2');
        $field1->getSource()->willReturn($source);
        $field2->getSource()->willReturn($source);
        $this->setGatherables([$field1, $field2]);

        $this->toSQL()->shouldEqual('SELECT source.field1, source.field2 FROM source');
    }

    function its_to_sql_with_gatherables_with_conflicting_sources_throws_exception(Source $source1, Source $source2, Field $field1, Field $field2)
    {
        $source1->getName()->willReturn('source1');
        $source2->getName()->willReturn('source2');
        $field1->getSource()->willReturn($source1);
        $field2->getSource()->willReturn($source2);
        $this->setGatherables([$field1, $field2]);

        $this->shouldThrow(TooManySourcesInExpressionException::class)->during('toSQL');
    }

    function its_to_sql_with_connectors_returns_string_with_accurate_joins(
        Source $source,
        Field $field,
        ExternalField $externalField,
        Connector $connector
    ) {
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $externalField->getConnector()->willReturn($connector);
        $externalField->toSQL()->willReturn('_attach_.field2');
        $connector->toSQL()->willReturn('JOIN attach _attach_ ON _attach_.attaching_field = source.field');

        $this->setGatherables([$field, $externalField]);

        $this->toSQL()->shouldEqual('SELECT source.field, _attach_.field2 FROM source JOIN attach _attach_ ON _attach_.attaching_field = source.field');
    }

    function its_to_sql_with_same_connectors_returns_string_with_accurate_joins(
        Source $source,
        Field $field,
        ExternalField $externalField1,
        ExternalField $externalField2,
        Connector $connector
    ) {
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $connector->toSQL()->willReturn('JOIN attach _attach_ ON _attach_.attaching_field = source.field');
        $externalField1->getConnector()->willReturn($connector);
        $externalField1->toSQL()->willReturn('_attach_.field2');
        $externalField2->getConnector()->willReturn($connector);
        $externalField2->toSQL()->willReturn('_attach_.field3');

        $this->setGatherables([$field, $externalField1, $externalField2]);

        $this->toSQL()->shouldEqual('SELECT source.field, _attach_.field2, _attach_.field3 FROM source JOIN attach _attach_ ON _attach_.attaching_field = source.field');
    }

    function its_to_sql_with_no_source_throws_exception(ExternalField $externalField, Connector $connector)
    {
        $externalField->getConnector()->willReturn($connector);

        $this->setGatherables([$externalField]);

        $this->shouldThrow(SourceNotFoundInExpressionException::class)->during('toSQL');
    }

    function its_get_parameters_with_no_filter_returns_empty_array()
    {
        $this->getParameters()->shouldEqual([]);
    }
}
