<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\ByFieldsConnector;
use RollAndRock\Reket\Type\ConnectingField;
use RollAndRock\Reket\Type\Field;

class DummyByFieldsConnector extends ByFieldsConnector
{
    private Field $attachingField;

    private ConnectingField $attachToField;

    public function __construct(Field $attachingField, ConnectingField $attachToField)
    {
        $this->attachingField = $attachingField;
        $this->attachToField = $attachToField;

        parent::__construct();
    }

    protected function attachingField(): Field
    {
        return $this->attachingField;
    }

    protected function attachToField(): ConnectingField
    {
        return $this->attachToField;
    }

    public function isOptional(): bool
    {
        return true;
    }
}
