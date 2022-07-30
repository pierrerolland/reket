<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Exception\SourceNotFoundInExpressionException;
use RollAndRock\Reket\Exception\TooManySourcesInExpressionException;
use RollAndRock\Reket\Type\Aggregate\Aggregate;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Expression;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Filter\Filter;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\GatherableExpression;
use RollAndRock\Reket\Type\Json\JsonObject;
use RollAndRock\Reket\Type\Sortable;
use RollAndRock\Reket\Type\SortingDirection;
use RollAndRock\Reket\Type\Source;
use RollAndRock\Reket\Type\SourceExpression;
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
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source');
    }

    function its_to_sql_returns_string_with_accurate_aliased_source(Source $source, Field $field)
    {
        $source->getConnectingAlias()->willReturn('so');
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('so.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);

        $this->toSQL()->shouldEqual('SELECT so.field FROM source so');
    }

    function its_to_sql_with_gatherables_with_same_source_returns_string_with_accurate_source(Source $source, Field $field1, Field $field2)
    {
        $source->getConnectingAlias()->willReturn(null);
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
        $source1->getConnectingAlias()->willReturn(null);
        $source1->getName()->willReturn('source1');
        $source2->getConnectingAlias()->willReturn(null);
        $source2->getName()->willReturn('source2');
        $field1->getSource()->willReturn($source1);
        $field2->getSource()->willReturn($source2);
        $this->setGatherables([$field1, $field2]);

        $this->shouldThrow(TooManySourcesInExpressionException::class)->during('toSQL');
    }

    function its_to_sql_with_connectors_returns_string_with_accurate_joins(
        Source        $source,
        Field         $field,
        ExternalField $externalField,
        Connector     $connector
    ) {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $externalField->getConnector()->willReturn($connector);
        $externalField->toSQL()->willReturn('_attach_.field2');
        $connector->toSQL()->willReturn('JOIN attach _attach_ ON _attach_.attaching_field = source.field');

        $this->setGatherables([$field, $externalField]);

        $this->toSQL()->shouldEqual('SELECT source.field, _attach_.field2 FROM source JOIN attach _attach_ ON _attach_.attaching_field = source.field');
    }

    function its_to_sql_with_json_object_connectors_returns_string_with_accurate_joins(
        Source        $source,
        Field         $field,
        ExternalField $externalField,
        Connector     $connector,
        JsonObject $jsonObject
    ) {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $externalField->getConnector()->willReturn($connector);
        $externalField->toSQL()->willReturn('_attach_.field2');
        $connector->toSQL()->willReturn('JOIN attach _attach_ ON _attach_.attaching_field = source.field');
        $jsonObject->getSourcedGatherables()->willReturn([$field, $externalField]);
        $jsonObject->toSQL()->willReturn('JSON_BUILD_OBJECT(...)');
        $this->setGatherables([$jsonObject]);

        $this->toSQL()->shouldEqual("SELECT JSON_BUILD_OBJECT(...) FROM source JOIN attach _attach_ ON _attach_.attaching_field = source.field");
    }

    function its_to_sql_with_aggregate_returns_string_with_accurate_joins(
        Source        $source,
        Field         $field,
        Aggregate $aggregate
    ) {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $aggregate->operateOn()->willReturn($field);
        $this->setGatherables([$aggregate]);
        $aggregate->toSQL()->willReturn('AGG(...)');

        $this->toSQL()->shouldEqual('SELECT AGG(...) FROM source');
    }

    function its_to_sql_with_same_connectors_returns_string_with_accurate_joins(
        Source        $source,
        Field         $field,
        ExternalField $externalField1,
        ExternalField $externalField2,
        Connector     $connector
    ) {
        $source->getConnectingAlias()->willReturn(null);
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

    function its_to_sql_returns_string_with_filters(Source $source, Field $field, Filter $filter)
    {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $filter->toSQL()->willReturn('condition');
        $this->setGatherables([$field]);
        $this->setFilters([$filter]);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source WHERE (condition)');
    }

    function its_to_sql_returns_string_with_sorting(
        Source $source,
        Field $field,
        Sortable $sortable,
        Gatherable $gatherable
    ) {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $gatherable->toSQL()->willReturn('source.date');
        $sortable->gatherable = $gatherable;
        $sortable->direction = SortingDirection::ASCENDING_ORDER;
        $this->setGatherables([$field]);
        $this->setSortables([$sortable]);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source ORDER BY source.date ASC');
    }

    function its_to_sql_returns_string_with_sorting_and_sortable_additional_source(
        Source $source,
        Connector $connector,
        Field $field,
        ExternalField $externalField,
        Sortable $sortable
    ) {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $connector->toSQL()->willReturn('JOIN attach _attach_ ON _attach_.attaching_field = source.field');
        $externalField->getConnector()->willReturn($connector);
        $externalField->toSQL()->willReturn('_attach_.date');
        $sortable->gatherable = $externalField;
        $sortable->direction = SortingDirection::ASCENDING_ORDER;
        $this->setGatherables([$field]);
        $this->setSortables([$sortable]);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source JOIN attach _attach_ ON _attach_.attaching_field = source.field ORDER BY _attach_.date ASC');
    }

    function its_to_sql_returns_string_with_limit(Source $source, Field $field)
    {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);
        $this->setCut(29);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source LIMIT 29');
    }

    function its_to_sql_returns_string_with_offset(Source $source, Field $field)
    {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);
        $this->setCut(null, 35);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source OFFSET 35');
    }

    function its_to_sql_returns_string_with_limit_and_offset(Source $source, Field $field)
    {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);
        $this->setCut(29, 35);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source LIMIT 29 OFFSET 35');
    }

    function its_to_sql_returns_string_with_grouping(Source $source, Field $field, Gatherable $aggregator)
    {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $aggregator->toSQL()->willReturn('source.agg');
        $this->setGatherables([$field]);
        $this->setAggregators([$aggregator]);

        $this->toSQL()->shouldEqual('SELECT source.field FROM source GROUP BY source.agg');
    }

    function its_to_sql_with_no_source_throws_exception(ExternalField $externalField, Connector $connector)
    {
        $externalField->getConnector()->willReturn($connector);

        $this->setGatherables([$externalField]);

        $this->shouldThrow(SourceNotFoundInExpressionException::class)->during('toSQL');
    }

    function its_get_parameters_with_no_filter_returns_empty_array(Source $source, Field $field)
    {
        $source->getName()->willReturn('source');
        $source->getConnectingAlias()->willReturn(null);
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);

        $this->getParameters()->shouldEqual([]);
    }

    function its_get_parameters_with_filters_returns_array(Source $source, Field $field, Filter $filter1, Filter $filter2)
    {
        $source->getName()->willReturn('source');
        $source->getConnectingAlias()->willReturn(null);
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);

        $filter1->getParameters()->willReturn([22, 29]);
        $filter1->toSQL()->willReturn('');
        $filter2->getParameters()->willReturn(['35', '44', 56]);
        $filter2->toSQL()->willReturn('');
        $this->setFilters([$filter1, $filter2]);

        $this->getParameters()->shouldEqual([22, 29, '35', '44', 56]);
    }

    function its_get_parameters_with_all_parameterables_returns_array(
        Filter $filter,
        GatherableExpression $gatherableExpression,
        Field $field,
        SourceExpression $sourceExpression,
        SourceExpression $connectedExpression,
        Connector $connector,
        ExternalField $externalField
    ) {
        $gatherableExpression->getParameters()->willReturn(['35']);
        $gatherableExpression->toSQL()->willReturn('');
        $sourceExpression->getParameters()->willReturn([29]);
        $sourceExpression->getName()->willReturn('');
        $sourceExpression->toSQL()->willReturn('');
        $sourceExpression->getConnectingAlias()->willReturn('');
        $field->getSource()->willReturn($sourceExpression);
        $field->toSQL()->willReturn('');
        $connectedExpression->getParameters()->willReturn([56]);
        $connector->attachTo()->willReturn($connectedExpression);
        $connector->toSQL()->willReturn('');
        $externalField->getConnector()->willReturn($connector);
        $externalField->toSQL()->willReturn('');
        $filter->getParameters()->willReturn([22]);
        $filter->toSQL()->willReturn('');
        $this->setGatherables([$gatherableExpression, $field, $externalField]);
        $this->setFilters([$filter]);
        $this->toSQL();

        $this->getParameters()->shouldEqual(['35', 29, 56, 22]);
    }
}
