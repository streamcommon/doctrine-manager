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

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\Common\Cache\ArrayCache;
use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

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
     * Get Container
     *
     * @return ContainerInterface
     */
    protected function getContainer() : ContainerInterface
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('config')->willReturn(true);
        $container->get('config')->willReturn($this->config);
        $container->has(ArrayCache::class)->willReturn(true);
        $container->get(ArrayCache::class)->willReturn(new ArrayCache());
        return $container->reveal();
    }
}
