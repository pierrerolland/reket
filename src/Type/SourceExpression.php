<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

use RollAndRock\Reket\Type\Internal\DoubleExternalField;
use RollAndRock\Reket\Type\Internal\DoubleField;

abstract class SourceExpression extends Expression implements Source
{
    public function getName(): string
    {
        return $this->getConnectingAlias();
    }

    public function gatherables(): array
    {
        return array_map(
            fn (Gatherable $gatherable) => $this->getGatherable($gatherable),
            $this->gatherables
        );
    }

    abstract public function getConnectingAlias(): string;

    private function getGatherable(Gatherable $gatherable): Gatherable
    {
        if ($gatherable instanceof Field) {
            return new DoubleField($gatherable, $this);
        }
        if ($gatherable instanceof ExternalField) {
            return new DoubleExternalField($gatherable, $this);
        }

        return $gatherable;
    }
}
