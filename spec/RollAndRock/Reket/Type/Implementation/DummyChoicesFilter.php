<?php

declare(strict_types=1);

namespace spec\RollAndRock\Reket\Type\Implementation;

use RollAndRock\Reket\Type\Filter\ChoicesFilter;
use RollAndRock\Reket\Type\Filter\Filter;

class DummyChoicesFilter extends ChoicesFilter
{
    /**
     * @param Filter[] $choices
     */
    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }
}
