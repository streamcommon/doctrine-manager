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

namespace Streamcommon\Doctrine\Manager;

use Streamcommon\Doctrine\Manager\Factory\{
    CacheFactory,
    ConfigurationFactory,
    ConnectionFactory,
    DriverFactory,
    EntityManagerFactory,
    EventManagerFactory,
    EntityResolverFactory};
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\Common\Cache\{
    ArrayCache,
    FilesystemCache,
    MemcachedCache,
    RedisCache,
    PredisCache,
    ZendDataCache};

/**
 * Class ConfigProvider
 *
 * @package Streamcommon\Doctrine\Manager
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'     => $this->getDoctrine(),
        ];
    }

    /**
     * Return dependencies configuration
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                // default orm
                'doctrine.driver.orm_default'          => DriverFactory::class,
                'doctrine.event_manager.orm_default'   => EventManagerFactory::class,
                'doctrine.configuration.orm_default'   => ConfigurationFactory::class,
                'doctrine.connection.orm_default'      => ConnectionFactory::class,
                'doctrine.entity_resolver.orm_default' => EntityResolverFactory::class,
                'doctrine.entity_manager.orm_default'  => EntityManagerFactory::class,
                // orm cached
                'doctrine.cache.array'                 => [CacheFactory::class, 'array'],
                'doctrine.cache.filesystem'            => [CacheFactory::class, 'filesystem'],
                'doctrine.cache.memcached'             => [CacheFactory::class, 'memcached'],
                'doctrine.cache.redis'                 => [CacheFactory::class, 'redis'],
                'doctrine.cache.predis'                => [CacheFactory::class, 'predis'],
                'doctrine.cache.zend_data'             => [CacheFactory::class, 'zend_data'],
            ],
        ];
    }

    /**
     * Return doctrine configuration
     *
     * @return array
     */
    public function getDoctrine(): array
    {
        return [
            'configuration'   => [
                'orm_default' => ['driver' => 'orm_default'],
            ],
            'connection'      => [
                'orm_default' => [
                    'configuration' => 'orm_default',
                    'event_manager' => 'orm_default',
                ],
            ],
            'entity_manager'  => [
                'orm_default' => [
                    'connection'    => 'orm_default',
                    'configuration' => 'orm_default',
                ],
            ],
            'event_manager'   => [
                'orm_default' => [
                    'subscribers' => [],
                ],
            ],
            'entity_resolver' => [
                'orm_default' => [
                    'resolvers' => [],
                ],
            ],
            'driver'          => [
                'orm_default' => [
                    'class_name' => MappingDriverChain::class,
                ],
            ],
            'cache'           => [
                'array'      => [
                    'class_name' => ArrayCache::class,
                    'namespace'  => 'Streamcommon\Doctrine\Manager',
                ],
                'filesystem' => [
                    'class_name' => FilesystemCache::class,
                    'path'       => 'data/doctrine/cache',
                    'namespace'  => 'Streamcommon\Doctrine\Manager',
                ],
                'memcached'  => [
                    'class_name' => MemcachedCache::class,
                    'instance'   => 'Streamcommon\Container\Alias\Cache\Memcached',
                    'namespace'  => 'Streamcommon\Doctrine\Manager',
                ],
                'redis'      => [
                    'class_name' => RedisCache::class,
                    'instance'   => 'Streamcommon\Container\Alias\Cache\Redis',
                    'namespace'  => 'Streamcommon\Doctrine\Manager',
                ],
                'predis'     => [
                    'class_name' => PredisCache::class,
                    'instance'   => 'Streamcommon\Container\Alias\Cache\Predis',
                    'namespace'  => 'Streamcommon\Doctrine\Manager',
                ],
                'zend_data'  => [
                    'class_name' => ZendDataCache::class,
                    'namespace'  => 'Streamcommon\Doctrine\Manager',
                ],
            ],
        ];
    }
}
