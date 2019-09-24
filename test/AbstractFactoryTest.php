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

use Aura\Di\Container as AuraContainer;
use Doctrine\DBAL\Logging\EchoSQLLogger;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\{
    ClassMetadataFactory,
    DefaultEntityListenerResolver,
    DefaultNamingStrategy,
    Driver\AnnotationDriver};
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Common\Cache\{ArrayCache, FilesystemCache, RedisCache, PredisCache, MemcachedCache};
use Doctrine\Common\Persistence\Mapping\Driver\{MappingDriverChain, PHPDriver, StaticPHPDriver};
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\ORM\Repository\DefaultRepositoryFactory;
use JSoumelidis\SymfonyDI\Config\{Config as SymfonyConfig, ContainerFactory as SymfonyContainerFactory};
use Predis\{ClientInterface, Client};
use Redis;
use Memcached;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Pimple\Psr11\Container as PimpleContainer;
use Streamcommon\Doctrine\Manager\Common\Factory\{
    Cache as CacheFactory,
    Driver as DriverFactory,
    EventManager as EventManagerFactory
};
use Streamcommon\Doctrine\Manager\DBAL\Factory\Connection as ConnectionFactory;
use Streamcommon\Doctrine\Manager\ORM\Factory\{
    Configuration as ConfigurationFactory,
    EntityManager as EntityManagerFactory,
    EntityResolver as EntityResolverFactory,
};
use Streamcommon\Doctrine\Manager\ConfigProvider;
use Streamcommon\Test\Doctrine\Manager\TestAssets\TestEventSubscriber;
use Symfony\Component\DependencyInjection\ContainerBuilder as SymfonyContainer;
use Zend\ServiceManager\ServiceManager;
use Zend\Pimple\Config\{Config as PimpleConfig, ContainerFactory as PimpleContainerFactory};
use Zend\AuraDi\Config\{Config as AuraConfig, ContainerFactory as AuraContainerFactory};

use function call_user_func_array;

/**
 * Class AbstractFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
abstract class AbstractFactoryTest extends TestCase
{
    /** @var array */
    protected $config = [
        'doctrine' => [
            'configuration'   => [
                'orm_default' => [
                    'result_cache'                  => 'memcached',
                    'metadata_cache'                => 'filesystem',
                    'query_cache'                   => 'predis',
                    'hydration_cache'               => 'redis',
                    'driver'                        => 'orm_default',
                    'class_metadata_factory_name'   => ClassMetadataFactory::class,
                    'default_repository_class_name' => EntityRepository::class,
                    'naming_strategy'               => DefaultNamingStrategy::class,
                    'repository_factory'            => DefaultRepositoryFactory::class,
                    'entity_listener_resolver'      => DefaultEntityListenerResolver::class,
                    'named_queries'                 => [
                        [
                            'name' => 'test',
                            'sql'  => 'SHOW DATABASES;'
                        ],
                    ],
                    'named_native_queries'          => [
                        [
                            'name' => 'test',
                            'rsm'  => ResultSetMapping::class,
                            'sql'  => 'SHOW DATABASES;'
                        ],
                    ],
                    'filters'                       => [
                        'test' => 'TestAssets\Filter'
                    ],
                    'sql_logger'                    => EchoSQLLogger::class,
                    'second_level_cache'            => [
                        'enabled'                    => true,
                        'regions'                    => [
                            [
                                'name' => 'test'
                            ],
                            [
                                'name' => null
                            ]
                        ],
                        'file_lock_region_directory' => __DIR__ . '/cache',
                    ]
                ],
            ],
            'connection'      => [
                'orm_default' => [
                    'configuration'     => 'orm_default',
                    'event_manager'     => 'orm_default',
                    'driver_class_name' => Driver::class,
                    'pdo_class_name'    => \PDO::class,
                    'params'            => [
                        'dbname'   => 'test',
                        'user'     => 'test',
                        'password' => 'test',
                        'host'     => 'localhost',
                        'platform' => SqlitePlatform::class
                    ],
                    'type_mapping'      => ['integer' => 'integer'],
                    'commented_types'   => ['integer'],
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
                    'subscribers' => [TestEventSubscriber::class],
                ],
            ],
            'entity_resolver' => [
                'orm_default' => [
                    'resolvers' => ['Original\Entity' => 'New\Entity'],
                ],
            ],
            'driver'          => [
                'orm_default'                 => [
                    'class_name' => MappingDriverChain::class,
                    'cache'      => 'array',
                    'drivers'    => [
                        'TestAssets\AnnotationEntity' => 'TestAssets\AnnotationEntity',
                        'TestAssets\FileEntity'       => 'TestAssets\FileEntity',
                        'TestAssets\Static'           => 'TestAssets\Static',
                    ]
                ],
                'TestAssets\AnnotationEntity' => [
                    'class_name' => AnnotationDriver::class,
                    'paths'      => [__DIR__ . '/TestAssets/AnnotationEntity']
                ],
                'TestAssets\FileEntity'       => [
                    'class_name' => PHPDriver::class,
                    'paths'      => [__DIR__ . '/TestAssets/FileEntity']
                ],
                'TestAssets\Static'           => [
                    'class_name' => StaticPHPDriver::class
                ],
            ],
            'cache'           => [
                'array'      => [
                    'class_name' => ArrayCache::class,
                    'namespace'  => 'Streamcommon\Doctrine\Manager\Interop',
                ],
                'filesystem' => [
                    'class_name' => FilesystemCache::class,
                    'namespace'  => 'Streamcommon\Doctrine\Manager\Interop',
                    'path'       => __DIR__
                ],
                'redis'      => [
                    'class_name' => RedisCache::class,
                    'instance'   => Redis::class,
                    'namespace'  => 'Streamcommon\Doctrine\Manager\Interop',
                ],
                'predis'     => [
                    'class_name' => PredisCache::class,
                    'instance'   => ClientInterface::class,
                    'namespace'  => 'Streamcommon\Doctrine\Manager\Interop',
                ],
                'memcached'  => [
                    'class_name' => MemcachedCache::class,
                    'instance'   => Memcached::class,
                    'namespace'  => 'Streamcommon\Doctrine\Manager\Interop',
                ],
            ],
        ]
    ];

    /**
     * Return container prop
     *
     * @return object|ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('config')->willReturn(true);
        $container->get('config')->willReturn($this->config);
        $container->has(ArrayCache::class)->willReturn(false);
        $container->has(FilesystemCache::class)->willReturn(false);
        $container->has(RedisCache::class)->willReturn(false);
        $container->has(PredisCache::class)->willReturn(false);
        $container->has(MemcachedCache::class)->willReturn(false);
        $container->has(MappingDriverChain::class)->willReturn(false);
        $container->get(TestEventSubscriber::class)->willReturn(new TestEventSubscriber());
        $container->get(\PDO::class)->willReturn(new \PDO('sqlite::memory:'));
        $container->get(SqlitePlatform::class)->willReturn(new SqlitePlatform());
        $container->has(AnnotationDriver::class)->willReturn(false);
        $container->has(PHPDriver::class)->willReturn(false);
        $container->has(StaticPHPDriver::class)->willReturn(true);
        $container->get(StaticPHPDriver::class)->willReturn(new StaticPHPDriver([]));
        $container->has('NotFoundA')->willReturn(false);
        $container->has(ClientInterface::class)->willReturn(true);
        $container->get(ClientInterface::class)->willReturn(new Client());
        $container->has(Redis::class)->willReturn(true);
        $redis = new Redis();
        $redis->connect('127.0.0.1');
        $container->get(Redis::class)->willReturn($redis);
        $container->get(Memcached::class)->willReturn(new Memcached());
        $container->has(ResultSetMapping::class)->willReturn(true);
        $container->get(ResultSetMapping::class)->willReturn(new ResultSetMapping());
        $container->get(EchoSQLLogger::class)->willReturn(new EchoSQLLogger());
        $container->get(DefaultNamingStrategy::class)->willReturn(new DefaultNamingStrategy());
        $container->get(DefaultRepositoryFactory::class)->willReturn(new DefaultRepositoryFactory());
        $container->get(DefaultEntityListenerResolver::class)->willReturn(new DefaultEntityListenerResolver());
        $container->has('TestAssets\ResultSetMapping')->willReturn(false);
        $container->has('TestAssets\ArrayCache')->willReturn(true);
        $container->get('TestAssets\ArrayCache')->willReturn(new ArrayCache());
        $container->has('TestAssets\NotExistClass')->willReturn(false);
        $container->get('doctrine.cache.array')->willReturn(call_user_func_array(
            new CacheFactory('array'),
            [
                $container->reveal(),
                'doctrine.cache.array'
            ]
        ));
        $container->get('doctrine.cache.filesystem')->willReturn(call_user_func_array(
            new CacheFactory('filesystem'),
            [
                $container->reveal(),
                'doctrine.cache.filesystem'
            ]
        ));
        $container->get('doctrine.cache.predis')->willReturn(call_user_func_array(
            new CacheFactory('predis'),
            [
                $container->reveal(),
                'doctrine.cache.predis'
            ]
        ));
        $container->get('doctrine.cache.redis')->willReturn(call_user_func_array(
            new CacheFactory('redis'),
            [
                $container->reveal(),
                'doctrine.cache.redis'
            ]
        ));
        $container->get('doctrine.cache.memcached')->willReturn(call_user_func_array(
            new CacheFactory('memcached'),
            [
                $container->reveal(),
                'doctrine.cache.memcached'
            ]
        ));
        $container->get('doctrine.driver.orm_default')->willReturn(call_user_func_array(
            new DriverFactory(),
            [
                $container->reveal(),
                'doctrine.driver.orm_default'
            ]
        ));
        $container->get('doctrine.entity_resolver.orm_default')->willReturn(call_user_func_array(
            new EntityResolverFactory(),
            [
                $container->reveal(),
                'doctrine.entity_resolver.orm_default'
            ]
        ));
        $container->get('doctrine.event_manager.orm_default')->willReturn(call_user_func_array(
            new EventManagerFactory(),
            [
                $container->reveal(),
                'doctrine.doctrine.event_manager.orm_default'
            ]
        ));
        $container->get('doctrine.configuration.orm_default')->willReturn(call_user_func_array(
            new ConfigurationFactory(),
            [
                $container->reveal(),
                'doctrine.configuration.orm_default'
            ]
        ));
        $container->get('doctrine.connection.orm_default')->willReturn(call_user_func_array(
            new ConnectionFactory(),
            [
                $container->reveal(),
                'doctrine.connection.orm_default'
            ]
        ));
        $container->get('doctrine.entity_manager.orm_default')->willReturn(call_user_func_array(
            new EntityManagerFactory(),
            [
                $container->reveal(),
                'doctrine.entity_manager.orm_default'
            ]
        ));
        return $container->reveal();
    }

    /**
     * Return Zend ServiceManager
     *
     * @return ServiceManager
     */
    protected function getZendServiceManager(): ServiceManager
    {
        $config                                                                = new ConfigProvider();
        $config                                                                = $config();
        $dependencies                                                          = $config['dependencies'];
        $dependencies['services']['config']                                    = $config;
        $dependencies['invokables']                                            = [
            'Streamcommon\Container\Alias\Cache\Memcached' => Memcached::class,
            'Streamcommon\Container\Alias\Cache\Predis'    => Client::class,
        ];
        $dependencies['factories']['Streamcommon\Container\Alias\Cache\Redis'] = function () {
            $redis = new Redis();
            $redis->connect('127.0.0.1');
            return $redis;
        };
        return new ServiceManager($dependencies);
    }

    /**
     * Return aura di
     *
     * @return AuraContainer
     */
    protected function getAuraContainer(): AuraContainer
    {
        $config                                                                                = new ConfigProvider();
        $dependencies                                                                          = $config();
        $dependencies['services']['config']                                                    = $config;
        $dependencies['dependencies']['invokables']                                            = [
            'Streamcommon\Container\Alias\Cache\Memcached' => Memcached::class,
            'Streamcommon\Container\Alias\Cache\Predis'    => Client::class,
        ];
        $dependencies['dependencies']['factories']['Streamcommon\Container\Alias\Cache\Redis'] = function () {
            $redis = new Redis();
            $redis->connect('127.0.0.1');
            return $redis;
        };

        $container = new AuraContainerFactory();
        return $container(new AuraConfig($dependencies));
    }

    /**
     * Return pimple di
     *
     * @return PimpleContainer
     */
    protected function getPimpleContainer(): PimpleContainer
    {
        $config                                                                                = new ConfigProvider();
        $dependencies                                                                          = $config();
        $dependencies['services']['config']                                                    = $config;
        $dependencies['dependencies']['invokables']                                            = [
            'Streamcommon\Container\Alias\Cache\Memcached' => Memcached::class,
            'Streamcommon\Container\Alias\Cache\Predis'    => Client::class,
        ];
        $dependencies['dependencies']['factories']['Streamcommon\Container\Alias\Cache\Redis'] = function () {
            $redis = new Redis();
            $redis->connect('127.0.0.1');
            return $redis;
        };

        $container = new PimpleContainerFactory();
        return $container(new PimpleConfig($dependencies));
    }

    /**
     * Return symfony di
     *
     * @return SymfonyContainer
     */
    protected function getSymfonyContainer(): SymfonyContainer
    {
        $config                                                                                = new ConfigProvider();
        $dependencies                                                                          = $config();
        $dependencies['services']['config']                                                    = $config;
        $dependencies['dependencies']['invokables']                                            = [
            'Streamcommon\Container\Alias\Cache\Memcached' => Memcached::class,
            'Streamcommon\Container\Alias\Cache\Predis'    => Client::class,
        ];
        $dependencies['dependencies']['factories']['Streamcommon\Container\Alias\Cache\Redis'] = function () {
            $redis = new Redis();
            $redis->connect('127.0.0.1');
            return $redis;
        };

        $container = new SymfonyContainerFactory();
        return $container(new SymfonyConfig($dependencies));
    }
}
