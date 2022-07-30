<?php

declare(strict_types=1);

namespace RollAndRock\Reket\Type;

/**
 * Extend this class so that it can be used in connectors
 */
abstract class ConnectingField extends Field
{
    private ?Connector $connector = null;

    public function useWithConnector(Connector $connector): void
    {
        $this->connector = $connector;
    }

    public function toSQL(): string
    {
        if (!$this->connector) {
            return parent::toSQL();
        }

        return sprintf(
            '%s.%s%s',
            $this->connector->getConnectingAlias(),
            $this->getName(),
            null !== $this->getAlias() ? ' AS ' . $this->getAlias() : ''
        );
    }
}
