<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Json;

use RollAndRock\Reket\Type\ExternalField;
use RollAndRock\Reket\Type\Field;
use RollAndRock\Reket\Type\FieldGatherable;
use RollAndRock\Reket\Type\Gatherable;

class JsonObject implements Gatherable
{
    private ?string $alias;

    /**
     * @var Gatherable[]
     */
    private array $gatherables;

    public function __construct(array $gatherables, ?string $alias = null)
    {
        $this->gatherables = $gatherables;
        $this->alias = $alias;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    /**
     * @return FieldGatherable[]
     */
    public function getSourcedGatherables(): array
    {
        return array_filter(
            $this->gatherables,
            static fn (Gatherable $gatherable) => $gatherable instanceof FieldGatherable
        );
    }

    public function toSQL(): string
    {
        return sprintf(
            'JSON_BUILD_OBJECT(%s)%s',
            implode(
                ', ',
                array_map(fn (Gatherable $gatherable) => sprintf("'%s', %s", $this->getKey($gatherable), $gatherable->toSQL()), $this->gatherables)
            ),
            null !== $this->getAlias() ? sprintf(' AS %s', $this->getAlias()) : ''
        );
    }

    private function getKey(Gatherable $gatherable): string
    {
        if ($gatherable->getAlias()) {
            return $gatherable->getAlias();
        }

        if ($gatherable instanceof Field) {
            return $gatherable->getName();
        }

        if ($gatherable instanceof ExternalField) {
            return $gatherable->getBaseField()->getName();
        }

        return $gatherable->toSQL();
    }
}
