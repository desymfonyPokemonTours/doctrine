<?php

namespace Desymfony\Doctrine\ORM\Tools;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\Tools\Setup;

class SetupStaticProxy
{
    /**
     * @param array $paths
     * @param bool $isDevMode
     *
     * @return Configuration
     */
    public function createYAMLMetadataConfiguration(array $paths, $isDevMode = false, $cache = null)
    {
        $proxyDir = __DIR__ . '/../../../../../../../../var/cache/doctrine';

        return Setup::createYAMLMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache);
    }
}
