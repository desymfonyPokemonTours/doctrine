<?php

namespace Desymfony\Doctrine\EntityManager;

use Doctrine\ORM\EntityManager;
use Desymfony\Doctrine\Connection\DesymfonyConnection;
use Desymfony\Doctrine\ORM\Tools\SetupStaticProxy;

class DesymfonyEntityManagerFactory
{
    /**
     * @var EntityManagerStaticProxy
     */
    private $emStaticProxy;

    /**
     * @var DesymfonyConnection
     */
    private $connection;

    /**
     * @var SetupStaticProxy
     */
    private $adminSetup;

    /**
     * @var array
     */
    private $mappingsDefault;

    public function __construct(
        EntityManagerStaticProxy $emStaticProxy,
        DesymfonyConnection $connection,
        SetupStaticProxy $adminSetup,
        array $mappingsDefault
    ) {
        $this->emStaticProxy = $emStaticProxy;
        $this->connection = $connection;
        $this->adminSetup = $adminSetup;
        $this->mappingsDefault = $mappingsDefault;
    }

    /**
     * @param bool $isDevMode
     * @param DesymfonyConnection|null $desymfonyConnection
     * @param array $mappingDirs
     *
     * @return EntityManager
     */
    public function create(
        $isDevMode = false,
        DesymfonyConnection $desymfonyConnection = null,
        $mappingDirs = []
    ) {
        $mappingDirs = array_merge($this->mappingsDefault, $mappingDirs);
        $emConfiguration = $this->adminSetup->createYAMLMetadataConfiguration(
            $mappingDirs,
            $isDevMode,
            null
        );

        $connection = null !== $desymfonyConnection
            ? $desymfonyConnection->getConnection($emConfiguration)
            : $this->connection->getConnection($emConfiguration);

        $entityManager = $this->emStaticProxy->create($connection, $emConfiguration);

        return new DesymfonyEntityManagerDecorator($entityManager);
    }
}
