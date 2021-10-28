<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Gatherable;
use RollAndRock\Reket\Type\Json\ExpressionResultJson;

class DummyExpressionResultJson extends ExpressionResultJson
{
    use DummyAliasableTrait;

    /**
     * @param Gatherable[] $gatherables
     */
    public function setPicks(array $gatherables): void
    {
        foreach ($gatherables as $gatherable) {
            $this->pick($gatherable);
        }
    }
}
