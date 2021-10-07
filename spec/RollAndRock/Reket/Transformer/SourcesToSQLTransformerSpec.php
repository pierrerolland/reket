<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\ConnectorToSQLTransformer;
use RollAndRock\Reket\Transformer\SourcesToSQLTransformer;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Source;

class SourcesToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SourcesToSQLTransformer::class);
    }

    function its_transform_returns_from_and_joins_string(
        Source $source,
        Connector $connector1,
        Connector $connector2,
        ExternalField $connector1AttachUsing,
        Gatherable $connector1AttachTo,
        Source $connector1AttachUsingSource,
        ExternalField $connector2AttachUsing,
        Gatherable $connector2AttachTo,
        Source $connector2AttachUsingSource
    ) {
        $source->getName()->willReturn('source');
        $connector1AttachUsingSource->getName()->willReturn('source1');
        $connector1AttachUsing->getSource()->willReturn($connector1AttachUsingSource);
        $connector1AttachUsing->getGatherSQL()->willReturn('_source1_source.id');
        $connector1AttachTo->getGatherSQL()->willReturn('source.id');
        $connector1->getConnectingAlias()->willReturn('_source1_source');
        $connector1->attachUsing()->willReturn($connector1AttachUsing);
        $connector1->attachTo()->willReturn($connector1AttachTo);
        $connector1->isOptional()->willReturn(false);
        $connector2AttachUsingSource->getName()->willReturn('source2');
        $connector2AttachUsing->getSource()->willReturn($connector2AttachUsingSource);
        $connector2AttachUsing->getGatherSQL()->willReturn('_source2_source1.id');
        $connector2AttachTo->getGatherSQL()->willReturn('source1.id');
        $connector2->getConnectingAlias()->willReturn('_source2_source1');
        $connector2->attachUsing()->willReturn($connector2AttachUsing);
        $connector2->attachTo()->willReturn($connector2AttachTo);
        $connector2->isOptional()->willReturn(false);

        $this
            ->transform($source, [$connector1, $connector2])
            ->shouldReturn('FROM source JOIN source1 _source1_source ON _source1_source.id = source.id JOIN source2 _source2_source1 ON _source2_source1.id = source1.id');
    }

    function its_transform_without_connectors_returns_from_string(Source $source)
    {
        $source->getName()->willReturn('source');

        $this->transform($source, [])->shouldReturn('FROM source');
    }
}
