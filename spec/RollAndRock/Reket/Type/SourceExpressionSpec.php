<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\SourceExpression;
use spec\RollAndRock\Reket\Type\Implementation\DummySourceExpression;

class SourceExpressionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummySourceExpression::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SourceExpression::class);
    }

    function its_get_name_returns_connecting_alias()
    {
        $this->setConnectingAlias('al');

        $this->getName()->shouldEqual('al');
    }
}
