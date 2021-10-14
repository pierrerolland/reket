<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\SourceExpression;

class DummySourceExpression extends SourceExpression
{
    private string $connectingAlias;

    public function getConnectingAlias(): string
    {
        return $this->connectingAlias;
    }

    public function setConnectingAlias(string $connectingAlias): void
    {
        $this->connectingAlias = $connectingAlias;
    }
}
