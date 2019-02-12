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

use Doctrine\ORM\Query\ResultSetMapping;
use PHPUnit\Framework\TestCase;
use Streamcommon\Doctrine\Container\Interop\Options\{
    Cache,
    Configuration,
    Connection};
use Streamcommon\Doctrine\Container\Interop\Options\Part\{
    ConnectionParams,
    NamedNativeQueries,
    NamedQuery,
    SecondLevelCache};

/**
 * Class OptionsTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
 */
class OptionsTest extends TestCase
{
    /**
     * Test cache options
     */
    public function testCacheOptions(): void
    {
        $config = [
            'class_name' => 'class_name_a',
            'namespace' => 'class_name_b',
            'instance' => 'class_name_c',
            'path' => '/tmp'
        ];
        $options = new Cache($config);

        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }

    /**
     * Test configuration options
     */
    public function testConfigurationOptions(): void
    {
        $config = [
            'result_cache' => 'result_test_array',
            'metadata_cache' => 'metadata_test_array',
            'query_cache' => 'query_test_array',
            'hydration_cache' => 'hydration_test_array',
            'driver' => 'orm_test',
            'auto_generate_proxies_classes' => false,
            'proxy_dir' => '/tmp',
            'proxy_namespace' => 'Test\\Project',
            'entity_namespaces' => [
                'Test\\Entity'
            ],
            'datetime_functions' => [
                'name' => 'class_name'
            ],
            'custom_string_functions' => [
                'name' => 'class_name'
            ],
            'custom_numeric_functions' => [
                'name' => 'class_name'
            ],
            'filters' => [
                'name' => 'class_name'
            ],
            'named_queries' => [
                new NamedQuery([
                    'name' => 'query',
                    'sql' => 'select'
                ])
            ],
            'named_native_queries' => [
                new NamedNativeQueries([
                    'name' => 'query',
                    'sql' => 'select',
                    'rsm' => new ResultSetMapping()
                ])
            ],
            'custom_hydration_modes' => [
                'name' => 'class_name',
            ],
            'naming_strategy' => 'some_strategy',
            'quote_strategy' => 'some_strategy',
            'default_repository_class_name' => 'some_repository_class',
            'repository_factory' => 'some_factory',
            'class_metadata_factory_name' => 'some_factory_name',
            'entity_listener_resolver' => 'resolver_class',
            'second_level_cache' => new SecondLevelCache(),
            'sql_logger' => 'logger'
        ];
        $options = new Configuration($config);

        foreach ($config as $item => $value) {
            if ($item === 'auto_generate_proxies_classes') {
                $this->assertEquals($value, $options->isAutoGenerateProxiesClasses());
            } else {
                $this->assertEquals($value, $options->{$item});
            }
        }
    }

    /**
     * Test connection options
     */
    public function testConnectionOptions(): void
    {
        $config = [
            'driver_class_name' => 'class_name_a',
            'wrapper_class_name' => 'class_name_b',
            'pdo_class_name' => 'pdo',
            'configuration' => 'orm_default',
            'event_manager' => 'orm_default',
            'params' => new ConnectionParams([
                'platform' => 'test'
            ]),
            'type_mapping' => [
                'test_string' => 'string',
            ],
            'commented_types' => [
                'test_string'
            ]
        ];
        $options = new Connection($config);

        foreach ($config as $item => $value) {
            $this->assertEquals($value, $options->{$item});
        }
    }
}
