<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Filter\Connecting;

use RollAndRock\Reket\Type\ConnectingField;
use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\Filter\EqualsFilter;
use RollAndRock\Reket\Type\Gatherable;

class FieldsConnectingFilter extends EqualsFilter implements ConnectingFilter
{
    private Field $attaching;

    public function __construct(Field $attaching, ConnectingField $attachTo, Connector $connector)
    {
        $attachTo->useWithConnector($connector);
        parent::__construct($attachTo);

        $this->attaching = $attaching;
    }

    public function attachTo(): ConnectingField
    {
        return $this->compareTo;
    }

    public function attaching(): Field
    {
        return $this->attaching;
    }

    protected function toFilter(): Gatherable
    {
        return $this->attaching;
    }
}