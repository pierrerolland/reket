<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\GatherableExpression;
use RollAndRock\Reket\Type\Source;
use spec\RollAndRock\Reket\Type\Implementation\DummyGatherableExpression;

class GatherableExpressionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyGatherableExpression::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GatherableExpression::class);
    }

    function its_to_sql_returns_string(Source $source, Field $field)
    {
        $source->getConnectingAlias()->willReturn(null);
        $source->getName()->willReturn('source');
        $field->toSQL()->willReturn('source.field');
        $field->getSource()->willReturn($source);
        $this->setGatherables([$field]);
        $this->setAlias('the_field');

        $this->toSQL()->shouldEqual('( SELECT source.field FROM source ) AS the_field');
    }
}
