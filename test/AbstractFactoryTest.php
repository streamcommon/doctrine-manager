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
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Factory\{
    CacheFactory,
    ConfigurationFactory,
    ConnectionFactory,
    DriverFactory,
    EntityManagerFactory,
    EntityResolverFactory,
    EventManagerFactory
};

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
                    'params' => [],
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
                    'cache' => 'array',
                    'paths' => [],
                    'drivers' => [],
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
