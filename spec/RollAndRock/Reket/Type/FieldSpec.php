<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Source;
use spec\RollAndRock\Reket\Type\Implementation\DummyField;

class FieldSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyField::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Field::class);
        $this->shouldBeAnInstanceOf(Gatherable::class);
    }

    function its_get_gather_sql_returns_string(Source $source)
    {
        $source->getName()->willReturn('source');

        $this->setSource($source);
        $this->setName('field');

        $this->getGatherSQL()->shouldEqual('source.field');
    }
}
