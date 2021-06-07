<?php
/**
 * This file is part of the doctrine-manager package, a StreamCommon open software project.
 *
 * @copyright (c) 2019 StreamCommon Team
 * @see https://github.com/streamcommon/doctrine-manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Streamcommon\Doctrine\Manager\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class RepositoryFactory
 *
 * @package Streamcommon\Doctrine\Manager\ORM\Factory
 */
final class RepositoryDecoratorFactory implements \Doctrine\ORM\Repository\RepositoryFactory
{
    /** @var EntityManagerDecoratorInterface  */
    private $emDecorator;
    /** @var array<string, ObjectRepository>|ObjectRepository[] */
    private $repositoryList = [];

    /**
     * RepositoryFactory constructor.
     *
     * @param EntityManagerDecoratorInterface $emDecorator
     */
    public function __construct(EntityManagerDecoratorInterface $emDecorator)
    {
        $this->emDecorator = $emDecorator;
    }

    /**
     * {@inheritDoc}
     *
     * @param EntityManagerInterface $entityManager
     * @param string                 $entityName
     * @return ObjectRepository|mixed
     */
    public function getRepository(EntityManagerInterface $entityManager, $entityName)
    {
        $entityManager  = $this->emDecorator;
        $repositoryHash = $entityManager->getClassMetadata($entityName)->getName() . spl_object_hash($entityManager);

        if (isset($this->repositoryList[$repositoryHash])) {
            return $this->repositoryList[$repositoryHash];
        }

        return $this->repositoryList[$repositoryHash] = $this->createRepository($entityManager, $entityName);
    }

    /**
     * Create a new repository instance for an entity class.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager The EntityManager instance.
     * @param string                               $entityName    The name of the entity.
     *
     * @return ObjectRepository
     */
    private function createRepository(EntityManagerInterface $entityManager, $entityName)
    {
        /* @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $metadata            = $entityManager->getClassMetadata($entityName);
        $repositoryClassName = $metadata->customRepositoryClassName
            ?: $entityManager->getConfiguration()->getDefaultRepositoryClassName();

        return new $repositoryClassName($entityManager, $metadata);
    }
}
