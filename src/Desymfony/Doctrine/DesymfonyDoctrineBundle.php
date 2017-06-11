<?php

namespace Desymfony\Doctrine;

use Desymfony\Doctrine\DependencyInjection\Symfony\DesymfonyDoctrineExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DesymfonyDoctrineBundle extends Bundle
{
    /**
     * Returns the bundle's container extension class.
     *
     * @return string
     */
    protected function getContainerExtensionClass()
    {
        return DesymfonyDoctrineExtension::class;
    }
}
