<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

class Sortable
{
    public Gatherable $gatherable;

    public string $direction;

    public function __construct(Gatherable $gatherable, string $direction)
    {
        $this->gatherable = $gatherable;
        $this->direction = $direction;
    }

    public static function create(Gatherable $gatherable, string $direction): self
    {
        return new Sortable($gatherable, $direction);
    }
}
