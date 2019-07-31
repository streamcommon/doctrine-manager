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

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\Common\Cache\{
    ArrayCache,
    FilesystemCache,
    MemcachedCache,
    RedisCache,
    PredisCache,
    ZendDataCache,
    WinCacheCache};

return [
    'configuration' => [
        'orm_default' => [
            'driver' => 'orm_default',
        ],
    ],
    'connection' => [
        'orm_default' => [
            'configuration' => 'orm_default',
            'event_manager' => 'orm_default',
        ],
    ],
    'entity_manager' => [
        'orm_default' => [
            'connection' => 'orm_default',
            'configuration' => 'orm_default',
        ],
    ],
    'event_manager' => [
        'orm_default' => [
            'subscribers' => [],
        ],
    ],
    'entity_resolver' => [
        'orm_default' => [
            'resolvers' => [],
        ],
    ],
    'driver' => [
        'orm_default' => [
            'class_name' => MappingDriverChain::class,
        ],
    ],
    'cache' => [
        'array' => [
            'class_name' => ArrayCache::class,
            'namespace' => 'Streamcommon\Doctrine\Manager',
        ],
        'filesystem' => [
            'class_name' => FilesystemCache::class,
            'path' => 'data/doctrine/cache',
            'namespace' => 'Streamcommon\Doctrine\Manager',
        ],
        'memcached' => [
            'class_name' => MemcachedCache::class,
            'instance' => 'Streamcommon\Container\Alias\Cache\Memcached',
            'namespace' => 'Streamcommon\Doctrine\Manager',
        ],
        'redis' => [
            'class_name' => RedisCache::class,
            'instance' => 'Streamcommon\Container\Alias\Cache\Redis',
            'namespace' => 'Streamcommon\Doctrine\Manager',
        ],
        'predis' => [
            'class_name' => PredisCache::class,
            'instance' => 'Streamcommon\Container\Alias\Cache\Predis',
            'namespace' => 'Streamcommon\Doctrine\Manager',
        ],
        'zend_data' => [
            'class_name' => ZendDataCache::class,
            'namespace' => 'Streamcommon\Doctrine\Manager',
        ],
        'win_cache' => [
            'class_name' => WinCacheCache::class,
            'namespace' => 'Streamcommon\Doctrine\Manager',
        ],
    ],
];
