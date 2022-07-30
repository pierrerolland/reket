<?php

namespace spec\RollAndRock\Reket\Type;

use PhpSpec\ObjectBehavior;
use RollAndRock\Reket\Type\Connectable;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Filter\Filter;
use RollAndRock\Reket\Type\SourceExpression;
use RollAndRock\Reket\Type\Table;
use spec\RollAndRock\Reket\Type\Implementation\DummyConnector;

class ConnectorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(DummyConnector::class);
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

    function its_to_sql_with_table_returns_string(Table $table, Filter $filter1, Filter $filter2)
    {
        $table->getName()->willReturn('source');
        $filter1->toSQL()->willReturn('condition1');
        $filter2->toSQL()->willReturn('condition2');
        $this->setOptional(false);
        $this->setFilters([$filter1, $filter2]);
        $this->setAttachTo($table);

        $this->toSQL()->shouldEqual('JOIN source _dummy ON (condition1) AND (condition2)');
    }

    function its_to_sql_with_source_expression_returns_string(SourceExpression $source, Filter $filter1, Filter $filter2)
    {
        $source->toSQL()->willReturn('SELECT * FROM source');
        $filter1->toSQL()->willReturn('condition1');
        $filter2->toSQL()->willReturn('condition2');
        $this->setOptional(false);
        $this->setFilters([$filter1, $filter2]);
        $this->setAttachTo($source);

        $this->toSQL()->shouldEqual('JOIN ( SELECT * FROM source ) _dummy ON (condition1) AND (condition2)');
    }

    function its_to_sql_returns_optional_string(Table $source, Filter $filter1, Filter $filter2)
    {
        $source->getName()->willReturn('source');
        $filter1->toSQL()->willReturn('condition1');
        $filter2->toSQL()->willReturn('condition2');
        $this->setOptional(true);
        $this->setFilters([$filter1, $filter2]);
        $this->setAttachTo($source);

        $this->toSQL()->shouldEqual('LEFT JOIN source _dummy ON (condition1) AND (condition2)');
    }
}
