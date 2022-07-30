<?php

namespace spec\RollAndRock\Reket\Type\Filter;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Expression;
use RollAndRock\Reket\Type\Filter\InExpressionFilter;
use RollAndRock\Reket\Type\Gatherable;
use spec\RollAndRock\Reket\Type\Implementation\DummyInExpressionFilter;

class InExpressionFilterSpec extends ObjectBehavior
{
    function let(Expression $expression)
    {
        $this->beAnInstanceOf(DummyInExpressionFilter::class);
        $this->beConstructedWith($expression);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InExpressionFilter::class);
    }

    function its_to_sql_returns_string(Expression $expression, Gatherable $toFilter)
    {
        $toFilter->toUnaliasedSQL()->willReturn('source.field');
        $this->setToFilter($toFilter);

        $expression->toSQL()->willReturn('expression');
        $expression->getParameters()->willReturn([22, 29, 35, 44, 56]);

        $this->toSQL()->shouldEqual('source.field IN ( expression )');
        $this->getParameters()->shouldEqual([22, 29, 35, 44, 56]);
    }
}
