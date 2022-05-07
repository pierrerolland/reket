<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Json;

use RollAndRock\Reket\Type\Gatherable;

abstract class ExpressionResultJson implements Gatherable
{
    /**
     * @var Gatherable[]
     */
    private array $gatherables;

    public function pick(Gatherable $gatherable): ExpressionResultJson
    {
        $this->gatherables[] = $gatherable;

        return $this;
    }

    public function toSQL(): string
    {
        return sprintf(
            '%s%s',
            $this->toUnaliasedSQL(),
            null !== $this->getAlias() ? sprintf(' AS %s', $this->getAlias()) : ''
        );
    }

    public function toUnaliasedSQL(): string
    {
        return sprintf(
            'ROW_TO_JSON(%s)',
            implode(', ', array_map(fn (Gatherable $gatherable) => $gatherable->toSQL(), $this->gatherables))
        );
    }
}
