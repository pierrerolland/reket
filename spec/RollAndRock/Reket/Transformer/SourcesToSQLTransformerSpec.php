<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\SourcesToSQLTransformer;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Source;

class SourcesToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SourcesToSQLTransformer::class);
    }

    function its_transform_returns_from_and_joins_string(Source $source, Connector $connector1, Connector $connector2)
    {
        $source->getName()->willReturn('source');
        $connector1->toSQL()->willReturn('JOIN source1 _source1_source ON _source1_source.id = source.id');
        $connector2->toSQL()->willReturn('JOIN source2 _source2_source1 ON _source2_source1.id = source1.id');

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
