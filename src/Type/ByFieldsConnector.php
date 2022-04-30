<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Type\Filter\Connecting\FieldsConnectingFilter;

abstract class ByFieldsConnector extends Connector
{
    public function __construct()
    {
        $this->useFilter(new FieldsConnectingFilter($this->attachingField(), $this->attachToField(), $this));
    }

    public function attachTo(): Source
    {
        return $this->attachToField()->getSource();
    }

    abstract protected function attachingField(): Field;

    abstract protected function attachToField(): ConnectingField;
}
