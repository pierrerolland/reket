<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Connectable;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Source;
use spec\RollAndRock\Reket\Type\Implementation\DummyConnector;

class ConnectorSpec extends ObjectBehavior
{
    function let(ExternalField $attachUsing)
    {
        $this->beAnInstanceOf(DummyConnector::class);
        $this->beConstructedWith($attachUsing);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Connector::class);
        $this->shouldBeAnInstanceOf(Connectable::class);
    }

    function its_get_connecting_alias_returns_string()
    {
        $this->getConnectingAlias()->shouldEqual('_dummy');
    }

    function its_get_attach_using_returns_external_field(ExternalField $attachUsing)
    {
        $this->attachUsing()->shouldEqual($attachUsing);
    }

    function its_to_sql_returns_string(Source $source, ExternalField $attachUsing, Gatherable $attachTo)
    {
        $this->setOptional(false);

        $source->getName()->willReturn('source');
        $attachUsing->getSource()->willReturn($source);
        $attachUsing->toSQL()->willReturn('_dummy.source_field');
        $attachTo->toSQL()->willReturn('target.target_field');
        $this->setAttachTo($attachTo);

        $this->toSQL()->shouldEqual('JOIN source _dummy ON _dummy.source_field = target.target_field');
    }

    function its_to_sql_returns_optional_string(Source $source, ExternalField $attachUsing, Gatherable $attachTo)
    {
        $this->setOptional(true);

        $source->getName()->willReturn('source');
        $attachUsing->getSource()->willReturn($source);
        $attachUsing->toSQL()->willReturn('_dummy.source_field');
        $attachTo->toSQL()->willReturn('target.target_field');
        $this->setAttachTo($attachTo);

        $this->toSQL()->shouldEqual('LEFT JOIN source _dummy ON _dummy.source_field = target.target_field');
    }
}
