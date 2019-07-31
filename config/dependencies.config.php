<?php
/**
 * This file is part of the doctrine-container-manager package, a StreamCommon open software project.
 *
 * @copyright (c) 2019 StreamCommon Team
 * @see https://github.com/streamcommon/doctrine-container-manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Streamcommon\Doctrine\Manager\Factory\{
    CacheFactory,
    ConfigurationFactory,
    ConnectionFactory,
    DriverFactory,
    EntityManagerFactory,
    EventManagerFactory,
    EntityResolverFactory};

return [
    'factories' => [
        // default orm
        'doctrine.driver.orm_default' => DriverFactory::class,
        'doctrine.event_manager.orm_default' => EventManagerFactory::class,
        'doctrine.configuration.orm_default' => ConfigurationFactory::class,
        'doctrine.connection.orm_default' => ConnectionFactory::class,
        'doctrine.entity_resolver.orm_default' => EntityResolverFactory::class,
        'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
        // orm cached
        'doctrine.cache.array' => [CacheFactory::class, 'array'],
        'doctrine.cache.filesystem' => [CacheFactory::class, 'filesystem'],
        'doctrine.cache.memcached' => [CacheFactory::class, 'memcached'],
        'doctrine.cache.redis' => [CacheFactory::class, 'redis'],
        'doctrine.cache.predis' => [CacheFactory::class, 'predis'],
        'doctrine.cache.zend_data' => [CacheFactory::class, 'zend_data'],
        'doctrine.cache.win_cache' => [CacheFactory::class, 'win_cache'],
    ],
];
