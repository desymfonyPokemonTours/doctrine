<?php

namespace Desymfony\Doctrine\DependencyInjection\Symfony;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class DesymfonyDoctrineExtension extends Extension
{
    const MAPPING_DIRS_PARAMETER = 'Desymfony.doctrine.orm.mapping';

    private static $mappingDirs = [];

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . DIRECTORY_SEPARATOR . 'config'));
        $this->loadDiConfigurations($loader);

        $container->setParameter(self::MAPPING_DIRS_PARAMETER, self::$mappingDirs);
    }

    /**
     * @param string $mappingDir
     */
    public static function addMappingDir($mappingDir)
    {
        self::$mappingDirs[] = $mappingDir;
    }

    private function loadDiConfigurations(YamlFileLoader $loader)
    {
        $loader->load('config.yml');
        $loader->load('services.yml');
    }
}
