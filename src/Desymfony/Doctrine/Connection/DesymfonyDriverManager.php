<?php

namespace Desymfony\Doctrine\Connection;

use Doctrine\Common\EventManager;
use Doctrine\ORM\Configuration;
use Doctrine\DBAL\DriverManager;

class DesymfonyDriverManager
{
    public function getConnection(array $params, Configuration $config = null, EventManager $eventManager = null)
    {
        return DriverManager::getConnection($params, $config, $eventManager);
    }
}
