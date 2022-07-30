<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Filter\Connecting;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\ConnectingField;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Filter\ComparisonFilter;
use RollAndRock\Reket\Type\Filter\Connecting\FieldsConnectingFilter;
use RollAndRock\Reket\Type\Filter\EqualsFilter;
use RollAndRock\Reket\Type\Filter\Filter;

class FieldsConnectingFilterSpec extends ObjectBehavior
{
    public function let(Field $attaching, ConnectingField $attachTo, Connector $connector)
    {
        $this->beAnInstanceOf(FieldsConnectingFilter::class);
        $this->beConstructedWith($attaching, $attachTo, $connector);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FieldsConnectingFilter::class);
        $this->shouldBeAnInstanceOf(EqualsFilter::class);
        $this->shouldBeAnInstanceOf(ComparisonFilter::class);
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function its_to_sql_returns_string(Field $attaching, ConnectingField $attachTo, Connector $connector)
    {
        $attaching->toUnaliasedSQL()->willReturn('attaching.field1');
        $attachTo->toSQL()->willReturn('attach_to.field2');

        $attachTo->useWithConnector($connector)->shouldBeCalledOnce();
        $this->toSQL()->shouldReturn('attaching.field1 = attach_to.field2');
    }

    public function its_attaching_returns_attaching_field(Field $attaching)
    {
        $this->attaching()->shouldReturn($attaching);
    }

    public function its_attaching_returns_attach_to_connecting_field(ConnectingField $attachTo)
    {
        $this->attachTo()->shouldReturn($attachTo);
    }
}
