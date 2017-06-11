<?php

namespace Desymfony\Doctrine\EntityManager;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;

class EntityManagerStaticProxy
{
    public function create(Connection $connection, Configuration $config)
    {
        return EntityManager::create($connection, $config);
    }
}
