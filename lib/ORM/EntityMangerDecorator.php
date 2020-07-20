<?php
/**
 * This file is part of the streamcommon/doctrine-manager package, a StreamCommon open software project.
 *
 * @copyright (c) 2020 StreamCommon
 * @see https://github.com/streamcommon/doctrine-manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Streamcommon\Doctrine\Manager\ORM;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\PessimisticLockException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\Mapping\ClassMetadataFactory;

/**
 * Class EntityMangerDecorator
 *
 * @package Streamcommon\Doctrine\Manager\ORM
 * @codeCoverageIgnore
 */
class EntityMangerDecorator implements EntityMangerDecoratorInterface
{
    /** @var EntityManager */
    protected $em;

    /**
     * EntityMangerDecorator constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     *
     * @return \Doctrine\ORM\Cache|null
     */
    public function getCache()
    {
        return $this->em->getCache();
    }

    /**
     * {@inheritDoc}
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->em->getConnection();
    }

    /**
     * {@inheritDoc}
     *
     * @return Query\Expr
     */
    public function getExpressionBuilder()
    {
        return $this->em->getExpressionBuilder();
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function beginTransaction()
    {
        $this->em->beginTransaction();
    }

    /**
     * {@inheritDoc}
     *
     * @param callable $func
     * @return boolean|mixed
     * @throws \Throwable
     */
    public function transactional($func)
    {
        return $this->em->transactional($func);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function commit()
    {
        $this->em->commit();
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function rollback()
    {
        $this->em->rollback();
    }

    /**
     * {@inheritDoc}
     *
     * @param string $dql
     * @return Query
     */
    public function createQuery($dql = '')
    {
        return $this->em->createQuery($dql);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $name
     * @return Query
     */
    public function createNamedQuery($name)
    {
        return $this->em->createNamedQuery($name);
    }

    /**
     * {@inheritDoc}
     *
     * @param string           $sql
     * @param ResultSetMapping $rsm
     * @return NativeQuery
     */
    public function createNativeQuery($sql, ResultSetMapping $rsm)
    {
        return $this->em->createNativeQuery($sql, $rsm);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $name
     * @return NativeQuery
     */
    public function createNamedNativeQuery($name)
    {
        return $this->em->createNamedNativeQuery($name);
    }

    /**
     * {@inheritDoc}
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return $this->em->createQueryBuilder();
    }

    /**
     * {@inheritDoc}
     *
     * @param string $entityName
     * @param mixed  $id
     * @return boolean|\Doctrine\Common\Proxy\Proxy|object|null
     * @throws ORMException
     */
    public function getReference($entityName, $id)
    {
        return $this->em->getReference($entityName, $id);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $entityName
     * @param mixed  $identifier
     * @return boolean|object|null
     */
    public function getPartialReference($entityName, $identifier)
    {
        return $this->em->getPartialReference($entityName, $identifier);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function close()
    {
        $this->em->close();
    }

    /**
     * {@inheritDoc}
     *
     * @param object  $entity
     * @param boolean $deep
     * @return object|void
     */
    public function copy($entity, $deep = false)
    {
        return $this->em->copy($entity, $deep);
    }

    /**
     * {@inheritDoc}
     *
     * @param object  $entity
     * @param integer $lockMode
     * @param null    $lockVersion
     * @return void
     *
     * @throws OptimisticLockException
     * @throws PessimisticLockException
     */
    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->em->lock($entity, $lockMode, $lockVersion);
    }

    /**
     * {@inheritDoc}
     *
     * @return \Doctrine\Common\EventManager
     */
    public function getEventManager()
    {
        return $this->em->getEventManager();
    }

    /**
     * {@inheritDoc}
     *
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->em->getConfiguration();
    }

    /**
     * {@inheritDoc}
     *
     * @return boolean
     */
    public function isOpen()
    {
        return $this->em->isOpen();
    }

    /**
     * {@inheritDoc}
     *
     * @return UnitOfWork
     */
    public function getUnitOfWork()
    {
        return $this->em->getUnitOfWork();
    }

    /**
     * {@inheritDoc}
     *
     * @param integer|string $hydrationMode
     * @return \Doctrine\ORM\Internal\Hydration\AbstractHydrator
     */
    public function getHydrator($hydrationMode)
    {
        return $this->em->getHydrator($hydrationMode);
    }

    /**
     * {@inheritDoc}
     *
     * @param integer|string $hydrationMode
     * @return \Doctrine\ORM\Internal\Hydration\AbstractHydrator
     * @throws ORMException
     */
    public function newHydrator($hydrationMode)
    {
        return $this->em->newHydrator($hydrationMode);
    }

    /**
     * {@inheritDoc}
     *
     * @return \Doctrine\ORM\Proxy\ProxyFactory
     */
    public function getProxyFactory()
    {
        return $this->em->getProxyFactory();
    }

    /**
     * {@inheritDoc}
     *
     * @return Query\FilterCollection
     */
    public function getFilters()
    {
        return $this->em->getFilters();
    }

    /**
     * {@inheritDoc}
     *
     * @return boolean
     */
    public function isFiltersStateClean()
    {
        return $this->em->isFiltersStateClean();
    }

    /**
     * {@inheritDoc}
     *
     * @return boolean
     */
    public function hasFilters()
    {
        return $this->em->hasFilters();
    }

    /**
     * {@inheritDoc}
     *
     * @param string $className
     * @param mixed  $id
     * @return object|null
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function find($className, $id)
    {
        return $this->em->find($className, $id);
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     * @return void
     * @throws ORMException
     */
    public function persist($object)
    {
        $this->em->persist($object);
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     * @return void
     * @throws ORMException
     */
    public function remove($object)
    {
        $this->em->remove($object);
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     * @return object
     * @throws ORMException
     */
    public function merge($object)
    {
        return $this->em->merge($object);
    }

    /**
     * {@inheritDoc}
     *
     * @param null $objectName
     * @return void
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function clear($objectName = null)
    {
        $this->em->clear($objectName);
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     * @return void
     */
    public function detach($object)
    {
        $this->em->detach($object);
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     * @return void
     * @throws ORMException
     */
    public function refresh($object)
    {
        $this->em->refresh($object);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     *
     * @param string $className
     * @template T
     * @return \Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository<T>
     */
    public function getRepository($className)
    {
        return $this->em->getRepository($className);
    }

    /**
     * {@inheritDoc}
     *
     * @return Mapping\ClassMetadataFactory|ClassMetadataFactory
     */
    public function getMetadataFactory()
    {
        return $this->em->getMetadataFactory();
    }

    /**
     * {@inheritDoc}
     *
     * @param object $obj
     * @return void
     */
    public function initializeObject($obj)
    {
        $this->em->initializeObject($obj);
    }

    /**
     * {@inheritDoc}
     *
     * @param object $object
     * @return boolean|mixed
     */
    public function contains($object)
    {
        return $this->em->contains($object);
    }

    /**
     * {@inheritDoc}
     *
     * @param string $className
     * @return Mapping\ClassMetadata
     */
    public function getClassMetadata($className)
    {
        return $this->em->getClassMetadata($className);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     * @throws ORMException
     */
    public function reset()
    {
        $this->em = EntityManager::create(
            $this->em->getConnection(),
            $this->em->getConfiguration(),
            $this->em->getEventManager()
        );
    }
}
