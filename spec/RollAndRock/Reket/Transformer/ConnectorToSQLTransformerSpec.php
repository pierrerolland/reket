<?php

namespace spec\RollAndRock\Reket\Transformer;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Transformer\ConnectorToSQLTransformer;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Source;

class ConnectorToSQLTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ConnectorToSQLTransformer::class);
    }

    function its_transform_returns_string(Field $from, Source $fromSource, Field $to, Source $toSource, Connector $connector)
    {
        $fromSource->getName()->willReturn('source_from');
        $toSource->getName()->willReturn('source_to');
        $from->getSource()->willReturn($fromSource);
        $from->getName()->willReturn('field_from');
        $to->getSource()->willReturn($toSource);
        $to->getName()->willReturn('field_to');
        $connector->from()->willReturn($from);
        $connector->to()->willReturn($to);
        $connector->isOptional()->willReturn(false);

        $this::transform($connector)->shouldEqual('JOIN source_from ON source_from.field_from = source_to.field_to');
    }
}
