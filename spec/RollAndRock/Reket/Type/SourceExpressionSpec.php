<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Internal\DoubleExternalField;
use RollAndRock\Reket\Type\Internal\DoubleField;
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

    function its_gatherables_returns_gatherables_list_with_changed_source(Gatherable $gatherable, Field $field, ExternalField $externalField)
    {
        $this->setGatherables([$gatherable, $field, $externalField]);

        $this->gatherables()[0]->shouldHaveType(Gatherable::class);
        $this->gatherables()[1]->shouldHaveType(DoubleField::class);
        $this->gatherables()[1]->getSource()->shouldBe($this);
        $this->gatherables()[2]->shouldHaveType(DoubleExternalField::class);
        $this->gatherables()[2]->getSource()->shouldBe($this);
    }
}
