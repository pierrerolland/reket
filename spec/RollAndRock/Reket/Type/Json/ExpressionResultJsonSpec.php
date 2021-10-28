<?php

namespace spec\RollAndRock\Reket\Type\Json;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Json\ExpressionResultJson;
use spec\RollAndRock\Reket\Type\Implementation\DummyExpressionResultJson;

class ExpressionResultJsonSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyExpressionResultJson::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExpressionResultJson::class);
    }

    function its_to_sql_returns_string(Gatherable $gatherable1, Gatherable $gatherable2)
    {
        $gatherable1->toSQL()->willReturn('source.field1');
        $gatherable2->toSQL()->willReturn('source.field2');

        $this->setPicks([$gatherable1, $gatherable2]);

        $this->toSQL()->shouldEqual('ROW_TO_JSON(source.field1, source.field2)');
    }

    function its_to_sql_returns_aliased_string(Gatherable $gatherable1, Gatherable $gatherable2)
    {
        $gatherable1->toSQL()->willReturn('source.field1');
        $gatherable2->toSQL()->willReturn('source.field2');
        $this->setAlias('aliased');

        $this->setPicks([$gatherable1, $gatherable2]);

        $this->toSQL()->shouldEqual('ROW_TO_JSON(source.field1, source.field2) AS aliased');
    }
}
