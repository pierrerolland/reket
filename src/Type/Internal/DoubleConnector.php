<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type\Internal;

use RollAndRock\Reket\Type\Connector;
use RollAndRock\Reket\Type\Filter\Connecting\FieldsConnectingFilter;
use RollAndRock\Reket\Type\Source;

class DoubleConnector extends Connector
{
    private Source $source;

    private Connector $inner;

    public function __construct(Source $source, Connector $inner)
    {
        $this->source = $source;
        $this->inner = $inner;
        $this->filters = $inner->getFilters();

        foreach ($this->filters as $i => $filter) {
            if ($filter instanceof FieldsConnectingFilter) {
                $attaching = $filter->attaching();
                $attachTo = $filter->attachTo();

                $this->filters[$i] = new FieldsConnectingFilter(
                    new DoubleField($attaching, $this->source),
                    $attachTo,
                    $this
                );
            }
        }
    }

    public function isOptional(): bool
    {
        return $this->inner->isOptional();
    }

    public function attachTo(): Source
    {
        return $this->inner->attachTo();
    }

    public function getConnectingAlias(): string
    {
        return $this->inner->getConnectingAlias();
    }
}
