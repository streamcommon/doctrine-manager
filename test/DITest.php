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

namespace Streamcommon\Test\Doctrine\Manager;

use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\{
    Configuration, EntityManager,
};
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Tools\ResolveTargetEntityListener as EntityResolver;
use Doctrine\Common\Cache\{
    ArrayCache, FilesystemCache, MemcachedCache, RedisCache, PredisCache, ZendDataCache,
};

/**
 * Class DITest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class DITest extends AbstractFactoryTest
{
    /**
     * Test Laminas factories
     *
     * @return void
     */
    public function testLaminasServiceManagerFactories(): void
    {
        $serviceManger = $this->getLaminasServiceManager();

        // orm test
        $this->assertInstanceOf(MappingDriver::class, $serviceManger->get('doctrine.driver.orm_default'));
        $this->assertInstanceOf(EventManager::class, $serviceManger->get('doctrine.event_manager.orm_default'));
        $this->assertInstanceOf(Configuration::class, $serviceManger->get('doctrine.configuration.orm_default'));
        $this->assertInstanceOf(Connection::class, $serviceManger->get('doctrine.connection.orm_default'));
        $this->assertInstanceOf(EntityResolver::class, $serviceManger->get('doctrine.entity_resolver.orm_default'));
        $this->assertInstanceOf(EntityManager::class, $serviceManger->get('doctrine.entity_manager.orm_default'));

        // cache test
        $this->assertInstanceOf(ArrayCache::class, $serviceManger->get('doctrine.cache.array'));
        $this->assertInstanceOf(FilesystemCache::class, $serviceManger->get('doctrine.cache.filesystem'));
        $this->assertInstanceOf(MemcachedCache::class, $serviceManger->get('doctrine.cache.memcached'));
        $this->assertInstanceOf(RedisCache::class, $serviceManger->get('doctrine.cache.redis'));
        $this->assertInstanceOf(PredisCache::class, $serviceManger->get('doctrine.cache.predis'));
        $this->assertInstanceOf(ZendDataCache::class, $serviceManger->get('doctrine.cache.zend_data'));
    }

    /**
     * Test aura factories
     *
     * @return void
     * @throws \Aura\Di\Exception\ServiceNotFound
     */
    public function testAuraFactories(): void
    {
        $container = $this->getAuraContainer();

        // orm test
        $this->assertInstanceOf(MappingDriver::class, $container->get('doctrine.driver.orm_default'));
        $this->assertInstanceOf(EventManager::class, $container->get('doctrine.event_manager.orm_default'));
        $this->assertInstanceOf(Configuration::class, $container->get('doctrine.configuration.orm_default'));
        $this->assertInstanceOf(Connection::class, $container->get('doctrine.connection.orm_default'));
        $this->assertInstanceOf(EntityResolver::class, $container->get('doctrine.entity_resolver.orm_default'));
        $this->assertInstanceOf(EntityManager::class, $container->get('doctrine.entity_manager.orm_default'));

        // cache test
        $this->assertInstanceOf(ArrayCache::class, $container->get('doctrine.cache.array'));
        $this->assertInstanceOf(FilesystemCache::class, $container->get('doctrine.cache.filesystem'));
        $this->assertInstanceOf(MemcachedCache::class, $container->get('doctrine.cache.memcached'));
        $this->assertInstanceOf(RedisCache::class, $container->get('doctrine.cache.redis'));
        $this->assertInstanceOf(PredisCache::class, $container->get('doctrine.cache.predis'));
        $this->assertInstanceOf(ZendDataCache::class, $container->get('doctrine.cache.zend_data'));
    }

    /**
     * Test aura factories
     *
     * @return void
     */
    public function testPimpleFactories(): void
    {
        $container = $this->getPimpleContainer();

        // orm test
        $this->assertInstanceOf(MappingDriver::class, $container->get('doctrine.driver.orm_default'));
        $this->assertInstanceOf(EventManager::class, $container->get('doctrine.event_manager.orm_default'));
        $this->assertInstanceOf(Configuration::class, $container->get('doctrine.configuration.orm_default'));
        $this->assertInstanceOf(Connection::class, $container->get('doctrine.connection.orm_default'));
        $this->assertInstanceOf(EntityResolver::class, $container->get('doctrine.entity_resolver.orm_default'));
        $this->assertInstanceOf(EntityManager::class, $container->get('doctrine.entity_manager.orm_default'));

        // cache test
        $this->assertInstanceOf(ArrayCache::class, $container->get('doctrine.cache.array'));
        $this->assertInstanceOf(FilesystemCache::class, $container->get('doctrine.cache.filesystem'));
        $this->assertInstanceOf(MemcachedCache::class, $container->get('doctrine.cache.memcached'));
        $this->assertInstanceOf(RedisCache::class, $container->get('doctrine.cache.redis'));
        $this->assertInstanceOf(PredisCache::class, $container->get('doctrine.cache.predis'));
        $this->assertInstanceOf(ZendDataCache::class, $container->get('doctrine.cache.zend_data'));
    }

    /**
     * Test symfony factories
     *
     * @return void
     * @throws \Exception
     */
    public function testSymphonyFactories(): void
    {
        $container = $this->getSymfonyContainer();

        // orm test
        $this->assertInstanceOf(MappingDriver::class, $container->get('doctrine.driver.orm_default'));
        $this->assertInstanceOf(EventManager::class, $container->get('doctrine.event_manager.orm_default'));
        $this->assertInstanceOf(Configuration::class, $container->get('doctrine.configuration.orm_default'));
        $this->assertInstanceOf(Connection::class, $container->get('doctrine.connection.orm_default'));
        $this->assertInstanceOf(EntityResolver::class, $container->get('doctrine.entity_resolver.orm_default'));
        $this->assertInstanceOf(EntityManager::class, $container->get('doctrine.entity_manager.orm_default'));

        // cache test
        $this->assertInstanceOf(ArrayCache::class, $container->get('doctrine.cache.array'));
        $this->assertInstanceOf(FilesystemCache::class, $container->get('doctrine.cache.filesystem'));
        $this->assertInstanceOf(MemcachedCache::class, $container->get('doctrine.cache.memcached'));
        $this->assertInstanceOf(RedisCache::class, $container->get('doctrine.cache.redis'));
        $this->assertInstanceOf(PredisCache::class, $container->get('doctrine.cache.predis'));
        $this->assertInstanceOf(ZendDataCache::class, $container->get('doctrine.cache.zend_data'));
    }
}
