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

use Doctrine\ORM\Query\ResultSetMapping;
use PHPUnit\Framework\TestCase;
use Streamcommon\Doctrine\Manager\Options\{
    Cache,
    Configuration,
    Connection,
    Driver,
    EntityManager,
    EntityResolver,
    EventManager};
use Streamcommon\Doctrine\Manager\Options\Part\{
    Cache\Region,
    ConnectionParams,
    NamedNativeQueries,
    NamedQuery,
    SecondLevelCache};
use Streamcommon\Doctrine\Manager\Exception\InvalidArgumentException;

/**
 * Class OptionsTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class OptionsTest extends TestCase
{
    /**
     * Test cache options
     *
     * @return void
     */
    public function testCacheOptions(): void
    {
        $config  = [
            'class_name' => 'class_name_a',
            'namespace'  => 'class_name_b',
            'instance'   => 'class_name_c',
            'path'       => '/tmp'
        ];
        $options = new Cache($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
        $this->assertEquals('/tmp', $options->getPath());
    }

    /**
     * Test configuration options
     *
     * @return void
     */
    public function testConfigurationOptions(): void
    {
        $config  = [
            'result_cache'                  => 'result_test_array',
            'metadata_cache'                => 'metadata_test_array',
            'query_cache'                   => 'query_test_array',
            'hydration_cache'               => 'hydration_test_array',
            'driver'                        => 'orm_test',
            'auto_generate_proxies_classes' => false,
            'proxy_dir'                     => '/tmp',
            'proxy_namespace'               => 'Test\\Project',
            'entity_namespaces'             => [
                'Test\\Entity'
            ],
            'datetime_functions'            => [
                'name' => 'class_name'
            ],
            'custom_string_functions'       => [
                'name' => 'class_name'
            ],
            'custom_numeric_functions'      => [
                'name' => 'class_name'
            ],
            'filters'                       => [
                'name' => 'class_name'
            ],
            'named_queries'                 => [
                new NamedQuery([
                    'name' => 'query',
                    'sql'  => 'select'
                ])
            ],
            'named_native_queries'          => [
                new NamedNativeQueries([
                    'name' => 'query',
                    'sql'  => 'select',
                    'rsm'  => new ResultSetMapping()
                ])
            ],
            'custom_hydration_modes'        => [
                'name' => 'class_name',
            ],
            'naming_strategy'               => 'some_strategy',
            'quote_strategy'                => 'some_strategy',
            'default_repository_class_name' => 'some_repository_class',
            'repository_factory'            => 'some_factory',
            'class_metadata_factory_name'   => 'some_factory_name',
            'entity_listener_resolver'      => 'resolver_class',
            'second_level_cache'            => new SecondLevelCache(),
            'sql_logger'                    => 'logger'
        ];
        $options = new Configuration($config);
        foreach ($config as $item => $value) {
            if ($item === 'auto_generate_proxies_classes') {
                $this->assertEquals($value, $options->isAutoGenerateProxiesClasses());
            } else {
                $this->assertEquals($value, $options->{$item});
            }
        }

        $options->setSecondLevelCache([
            'enabled'                    => true,
            'default_life_time'          => 13,
            'default_lock_life_time'     => 42,
            'file_lock_region_directory' => '/tmp',
        ]);
        $this->assertInstanceOf(SecondLevelCache::class, $options->getSecondLevelCache());

        $this->expectException(InvalidArgumentException::class);
        $options->setSecondLevelCache(InvalidArgumentException::class);
    }

    /**
     * Test connection options
     *
     * @return void
     */
    public function testConnectionOptions(): void
    {
        $config  = [
            'driver_class_name'  => 'class_name_a',
            'wrapper_class_name' => 'class_name_b',
            'pdo_class_name'     => 'pdo',
            'configuration'      => 'orm_default',
            'event_manager'      => 'orm_default',
            'params'             => new ConnectionParams([
                'platform' => 'test'
            ]),
            'type_mapping'       => [
                'test_string' => 'string',
            ],
            'commented_types'    => [
                'test_string'
            ]
        ];
        $options = new Connection($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }

        $this->expectException(InvalidArgumentException::class);
        $options->setParams(InvalidArgumentException::class);
    }

    /**
     * Test driver options
     *
     * @return void
     */
    public function testDriverOptions(): void
    {
        $config  = [
            'class_name'      => 'test_name',
            'cache'           => 'array',
            'extension'       => 'ext',
            'global_basename' => 'name',
            'paths'           => [
                '/tmp'
            ],
            'drivers'         => [
                'orm_test' => 'driver_name'
            ],
        ];
        $options = new Driver($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test entityManager options
     *
     * @return void
     */
    public function testEntityManagerOptions(): void
    {
        $config  = [
            'connection'    => 'orm_test_a',
            'configuration' => 'orm_test_b',
        ];
        $options = new EntityManager($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test entityResolver options
     *
     * @return void
     */
    public function testEntityResolverOptions(): void
    {
        $config  = [
            'resolvers' => [
                'alias' => 'name'
            ],
        ];
        $options = new EntityResolver($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test eventManager options
     *
     * @return void
     */
    public function testEventManagerOptions():void
    {
        $config  = [
            'entity_resolver' => 'orm_test',
            'subscribers'     => [
                'alias' => 'name'
            ],
        ];
        $options = new EventManager($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test cache region options
     *
     * @return void
     */
    public function testPartCacheRegionOptions(): void
    {
        $config  = [
            'name'           => 'test',
            'life_time'      => 13,
            'lock_life_time' => 42,
        ];
        $options = new Region($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test connection params options
     *
     * @return void
     */
    public function testPartConnectionParamsOptions(): void
    {
        $config  = [
            'platform' => 'pdo',
            'db_name'  => 'test',
            'user'     => 'user',
            'password' => 'password',
            'host'     => 'localhost',
            'port'     => 3216,
            'charset'  => 'utf8',
        ];
        $options = new ConnectionParams($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test namedNativeQueries options
     *
     * @return void
     */
    public function testPartNamedNativeQueries(): void
    {
        $config  = [
            'name' => 'query',
            'sql'  => 'select',
            'rsm'  => new ResultSetMapping()
        ];
        $options = new NamedNativeQueries($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test namedQuery options
     *
     * @return void
     */
    public function testNamedQueryOptions(): void
    {
        $config  = [
            'name' => 'query',
            'sql'  => 'select',
        ];
        $options = new NamedQuery($config);
        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test second level cache options
     *
     * @return void
     */
    public function testSecondLevelCacheOptions(): void
    {
        $config  = [
            'enabled'                    => true,
            'default_life_time'          => 13,
            'default_lock_life_time'     => 42,
            'file_lock_region_directory' => '/tmp',
            'regions'                    => [
                new Region([
                    'name'           => 'test',
                    'life_time'      => 13,
                    'lock_life_time' => 42,
                ])
            ]
        ];
        $options = new SecondLevelCache($config);
        foreach ($config as $item => $value) {
            if ($item === 'enabled') {
                $this->assertEquals($value, $options->isEnabled());
            } else {
                $this->assertEquals($value, $options->{$item});
            }
        }
    }
}
