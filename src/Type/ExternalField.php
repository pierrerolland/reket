<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

interface ExternalField
{
    public function getConnector(): Connector;

    public function getBaseField(): Field;
}
