<?php
/**
 * This file is part of the Common package, a StreamCommon open software project.
 *
 * @copyright (c) 2019 StreamCommon Team.
 * @see https://github.com/streamcommon/doctrine-container-interop
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Streamcommon\Test\Doctrine\Container\Interop;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Persistence\Mapping\Driver\{MappingDriverChain, PHPDriver};
use Doctrine\DBAL\Driver\PDOSqlite\Driver;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Factory\{
    CacheFactory,
    ConfigurationFactory,
    ConnectionFactory,
    DriverFactory,
    EntityManagerFactory,
    EntityResolverFactory,
    EventManagerFactory};
use Streamcommon\Test\Doctrine\Container\Interop\TestAssets\TestEventSubscriber;

/**
 * Class AbstractFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
 */
abstract class AbstractFactoryTest extends TestCase
{
    /** @var array */
    protected $config = [
        'doctrine' => [
            'configuration' => [
                'orm_default' => [
                    'result_cache' => 'array',
                    'metadata_cache' => 'array',
                    'query_cache' => 'array',
                    'hydration_cache' => 'array',
                    'driver' => 'orm_default',
                ],
            ],
            'connection' => [
                'orm_default' => [
                    'configuration' => 'orm_default',
                    'event_manager' => 'orm_default',
                    'driver_class_name' => Driver::class,
                    'pdo_class_name' => \PDO::class,
                    'params' => [
                        'dbname' => 'test',
                        'user' => 'test',
                        'password' => 'test',
                        'host' => 'localhost',
                        'platform' => SqlitePlatform::class
                    ],
                    'type_mapping' => [
                        'integer' => 'integer',
                    ],
                    'commented_types' => [
                        'integer'
                    ],
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
                    'subscribers' => [
                        TestEventSubscriber::class
                    ],
                ],
            ],
            'entity_resolver' => [
                'orm_default' => [
                    'resolvers' => [
                        'Original\Entity' => 'New\Entity',
                    ],
                ],
            ],
            'driver' => [
                'orm_default' => [
                    'class_name' => MappingDriverChain::class,
                    'cache' => 'array',
                    'drivers' => [
                        'TestAssets\AnnotationEntity' => 'TestAssets\AnnotationEntity',
                        'TestAssets\FileEntity' => 'TestAssets\FileEntity'
                    ]
                ],
                'TestAssets\AnnotationEntity' => [
                    'class_name' => AnnotationDriver::class,
                    'paths' => [
                        __DIR__ . '/TestAssets/AnnotationEntity'
                    ]
                ],
                'TestAssets\FileEntity' => [
                    'class_name' => PHPDriver::class,
                    'paths' => [
                        __DIR__ . '/TestAssets/FileEntity'
                    ]
                ],
            ],
            'cache' => [
                'array' => [
                    'class_name' => ArrayCache::class,
                    'namespace' => 'Streamcommon\Doctrine\Manager\Interop',
                ]
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
        $container->has(MappingDriverChain::class)->willReturn(false);
        $container->get(TestEventSubscriber::class)->willReturn(new TestEventSubscriber());
        $container->get(\PDO::class)->willReturn(new \PDO('sqlite::memory:'));
        $container->get(SqlitePlatform::class)->willReturn(new SqlitePlatform());
        $container->has(AnnotationDriver::class)->willReturn(false);
        $container->get('doctrine.cache.array')->willReturn(call_user_func_array(
            new CacheFactory(),
            [
                $container->reveal(),
                'doctrine.cache.array'
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
}
