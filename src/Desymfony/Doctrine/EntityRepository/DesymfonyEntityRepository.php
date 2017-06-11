<?php

namespace Desymfony\Doctrine\EntityRepository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Desymfony\Doctrine\EntityManager\DesymfonyEntityManagerDecorator;

abstract class DesymfonyEntityRepository extends EntityRepository
{
    /**
     * DesymfonyEntityRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param \Doctrine\ORM\Mapping\ClassMetadata | ClassMetadataFactory $classMetadata
     */
    public function __construct(EntityManagerInterface $entityManager, $classMetadata)
    {
        if ($entityManager instanceof DesymfonyEntityManagerDecorator &&
            $classMetadata instanceof ClassMetadataFactory
        ) {
            $classMetadataFactory = $classMetadata;
            $classMetadataFactory->setEntityManager($entityManager);
            $classMetadata = $classMetadataFactory->getMetadataFor(ltrim($this->getEntityNamespace(), '\\'));
        }

        parent::__construct($entityManager, $classMetadata);
    }

    abstract protected function getEntityNamespace();
}
