<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\SourcesToSQLTransformer;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Source;
use RollAndRock\Reket\Type\SourceExpression;

class SourcesToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SourcesToSQLTransformer::class);
    }

    function its_transform_returns_from_and_joins_string(Source $source, Connector $connector1, Connector $connector2)
    {
        $source->getName()->willReturn('source');
        $source->getConnectingAlias()->willReturn(null);
        $connector1->toSQL()->willReturn('JOIN source1 _source1_source ON _source1_source.id = source.id');
        $connector2->toSQL()->willReturn('JOIN source2 _source2_source1 ON _source2_source1.id = source1.id');

        $this
            ->transform($source, [$connector1, $connector2])
            ->shouldReturn('FROM source JOIN source1 _source1_source ON _source1_source.id = source.id JOIN source2 _source2_source1 ON _source2_source1.id = source1.id');
    }

    function its_transform_without_connectors_returns_from_string(Source $source)
    {
        $source->getName()->willReturn('source');
        $source->getConnectingAlias()->willReturn(null);

        $this->transform($source, [])->shouldReturn('FROM source');
    }

    function its_transform_with_source_expression_returns_from_string(SourceExpression $sourceExpression)
    {
        $sourceExpression->toSQL()->willReturn('SELECT ...');
        $sourceExpression->getConnectingAlias()->willReturn('a');

        $this->transform($sourceExpression, [])->shouldReturn('FROM (SELECT ...) a');
    }

    function its_transform_returns_from_with_alias_and_joins_string(Source $source, Connector $connector1, Connector $connector2)
    {
        $source->getName()->willReturn('source');
        $source->getConnectingAlias()->willReturn('so');
        $connector1->toSQL()->willReturn('JOIN source1 _source1_source ON _source1_source.id = so.id');
        $connector2->toSQL()->willReturn('JOIN source2 _source2_source1 ON _source2_source1.id = so.id');

        $this
            ->transform($source, [$connector1, $connector2])
            ->shouldReturn('FROM source so JOIN source1 _source1_source ON _source1_source.id = so.id JOIN source2 _source2_source1 ON _source2_source1.id = so.id');
    }

    function its_transform_without_connectors_returns_from_with_alias_string(Source $source)
    {
        $source->getName()->willReturn('source');
        $source->getConnectingAlias()->willReturn('so');

        $this->transform($source, [])->shouldReturn('FROM source so');
    }
}
