<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Exception\SourceNotFoundInExpressionException;
use RollAndRock\Reket\Exception\TooManySourcesInExpressionException;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Expression;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Filter\Filter;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Sortable;
use RollAndRock\Reket\Type\SortingDirection;
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

    function its_get_parameters_with_no_filter_returns_empty_array()
    {
        $this->getParameters()->shouldEqual([]);
    }

    function its_get_parameters_with_filters_returns_array(Filter $filter1, Filter $filter2)
    {
        $filter1->getParameters()->willReturn([22, 29]);
        $filter2->getParameters()->willReturn(['35', '44', 56]);
        $this->setFilters([$filter1, $filter2]);

        $this->getParameters()->shouldEqual([22, 29, '35', '44', 56]);
    }
}
