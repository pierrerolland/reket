<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\ConnectorToSQLTransformer;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Source;

class ConnectorToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ConnectorToSQLTransformer::class);
    }

    function its_transform_returns_string(
        ExternalField $attachUsing,
        Gatherable $attachTo,
        Source $attachUsingSource,
        Connector $connector
    ) {
        $attachUsingSource->getName()->willReturn('source');
        $attachUsing->getSource()->willReturn($attachUsingSource);
        $attachUsing->getGatherSQL()->willReturn('_source_target_connect.id');
        $attachTo->getGatherSQL()->willReturn('target.id');
        $connector->getConnectingAlias()->willReturn('_source_target_connect');
        $connector->attachUsing()->willReturn($attachUsing);
        $connector->attachTo()->willReturn($attachTo);
        $connector->isOptional()->willReturn(false);

        $this::transform($connector)->shouldEqual('JOIN source _source_target_connect ON _source_target_connect.id = target.id');
    }

    function its_transform_with_optional_returns_string(
        ExternalField $attachUsing,
        Gatherable $attachTo,
        Source $attachUsingSource,
        Connector $connector
    ) {
        $attachUsingSource->getName()->willReturn('source');
        $attachUsing->getSource()->willReturn($attachUsingSource);
        $attachUsing->getGatherSQL()->willReturn('_source_target_connect.id');
        $attachTo->getGatherSQL()->willReturn('target.id');
        $connector->getConnectingAlias()->willReturn('_source_target_connect');
        $connector->attachUsing()->willReturn($attachUsing);
        $connector->attachTo()->willReturn($attachTo);
        $connector->isOptional()->willReturn(true);

        $this::transform($connector)->shouldEqual('LEFT JOIN source _source_target_connect ON _source_target_connect.id = target.id');
    }
}
