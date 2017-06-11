<?php

namespace Desymfony\Doctrine\Connection;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;

class DesymfonyConnection
{
    /**
     * @var DesymfonyDriverManager
     */
    private $driverManager;

    /**
     * @var array
     */
    private $connectionParams;

    public function __construct(DesymfonyDriverManager $driverManager, array $connectionParams)
    {
        $this->driverManager = $driverManager;
        $this->connectionParams = $connectionParams;
    }

    /**
     * @param Configuration $emConfiguration
     *
     * @return Connection
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getConnection(Configuration $emConfiguration)
    {
        return $this->driverManager->getConnection($this->connectionParams, $emConfiguration);
    }
}
