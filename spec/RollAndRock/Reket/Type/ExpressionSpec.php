<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
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
        $field->getGatherSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source');
    }

    function its_to_sql_with_gatherables_with_same_source_returns_string_with_accurate_source(Source $source, Field $field1, Field $field2)
    {
        $source->getName()->willReturn('source');
        $field1->getGatherSQL()->willReturn('source.field1');
        $field2->getGatherSQL()->willReturn('source.field2');
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

        $this->shouldThrow(TooManySourcesInExpressionException::class)->during('toSQL', [[$field1, $field2]]);
    }

    function its_to_sql_with_connectors_returns_string_with_accurate_joins(
        Source $source,
        Source $connectorAttachUsingSource,
        Field $field,
        ExternalField $externalField,
        ExternalField $connectorAttachUsing,
        Connector $connector
    ) {
        $source->getName()->willReturn('source');
        $field->getGatherSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $connectorAttachUsingSource->getName()->willReturn('attach');
        $connectorAttachUsing->getGatherSQL()->willReturn('_attach_.attaching_field');
        $connector->getConnectingAlias()->willReturn('_attach_');
        $connectorAttachUsing->getSource()->willReturn($connectorAttachUsingSource);
        $connector->attachUsing()->willReturn($connectorAttachUsing);
        $connector->attachTo()->willReturn($field);
        $connector->isOptional()->willReturn(false);
        $externalField->getConnector()->willReturn($connector);
        $externalField->getGatherSQL()->willReturn('_attach_.field2');

        $this->setGatherables([$field, $externalField]);

        $this->toSQL()->shouldEqual('SELECT source.field, _attach_.field2 FROM source JOIN attach _attach_ ON _attach_.attaching_field = source.field');
    }
}
