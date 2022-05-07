<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Aggregate;

use RollAndRock\Reket\Type\Gatherable;

abstract class Aggregate implements Gatherable
{
    protected ?Gatherable $operateOn = null;

    protected ?string $alias = null;

    public function __construct(?string $alias = null, ?Gatherable $actOn = null)
    {
        $this->alias = $alias;
        $this->operateOn = $actOn;
    }

    public function toSQL(): string
    {
        return sprintf(
            '%s%s',
            $this->toUnaliasedSQL(),
            null !== $this->getAlias() ? ' AS ' . $this->getAlias() : ''
        );
    }

    public function toUnaliasedSQL(): string
    {
        return sprintf(
            '%s(%s)',
            $this->action(),
            null !== $this->operateOn ? $this->operateOn->toSQL() : '1'
        );
    }

    abstract protected function action(): string;

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function operateOn(): ?Gatherable
    {
        return $this->operateOn;
    }
}
