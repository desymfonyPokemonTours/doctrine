<?php

namespace Desymfony\Doctrine\DependencyInjection\Symfony\Compiler;

use Desymfony\Doctrine\Connection\DesymfonyConnection;
use Desymfony\Doctrine\EntityManager\DesymfonyEntityManagerDecorator;
use Desymfony\Doctrine\EntityRepository\DesymfonyEntityRepository;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RegisterEntityRepositoryServicesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasParameter('desymfony.doctrine.orm.entity_repositories_config_params')) {
            $entityRepositoriesConfig = $container->getParameter(
                'desymfony.doctrine.orm.entity_repositories_config_params'
            );

            foreach ($entityRepositoriesConfig as $configName => $entityRepositoryConfig) {
                $currentEntityManagerServiceId = 'desymfony.doctrine.entity_manager_'.$configName;

                $container->setDefinition(
                    $currentEntityManagerServiceId,
                    $this->buildEntityManagerDefinition($entityRepositoryConfig)
                );

                $container->setDefinition(
                    'desymfony.doctrine.entity_repository_'. $configName,
                    $this->buildEntityRepositoryDefinition($currentEntityManagerServiceId)

                );
            }
        }
    }

    private function buildEntityManagerDefinition(array $entityRepositoryConfig)
    {
        $entityManagerDefinition = new Definition(DesymfonyEntityManagerDecorator::class);
        $entityManagerDefinition->setFactory(
            [$this->buildReference('desymfony.doctrine.entity_manager_factory'),
             'create']
        );

        $currentConnection = $this->buildDefinition(
            DesymfonyConnection::class,
            [
                $this->buildReference('desymfony.doctrine.driver_manager'),
                $entityRepositoryConfig['dbal'],
                $entityRepositoryConfig['mapping_dirs']
            ]
        );

        $entityManagerDefinition->setArguments(['%is_debug_mode%', $currentConnection]);

        return $entityManagerDefinition;
    }

    /**
     * @param string $entityManagerServiceId
     *
     * @return Definition
     */
    private function buildEntityRepositoryDefinition($entityManagerServiceId)
    {
        $entityRepositoryDefinition = $this->buildDefinition(
            DesymfonyEntityRepository::class,
            [
                $this->buildReference('desymfony.doctrine.class_metadata_fatory'),
                $this->buildReference($entityManagerServiceId),
            ]
        );

        $entityRepositoryDefinition->setAbstract(true);

        return $entityRepositoryDefinition;
    }

    private function buildDefinition($serviceClass, array $arguments = [])
    {
        return new Definition($serviceClass, $arguments);
    }

    private function buildReference($serviceId)
    {
        return new Reference($serviceId);
    }
}
