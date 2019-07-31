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

declare(strict_types=1);

namespace Streamcommon\Test\Doctrine\Manager;

use Doctrine\ORM\Configuration;
use Streamcommon\Doctrine\Manager\Exception\RuntimeException;
use Streamcommon\Doctrine\Manager\Factory\ConfigurationFactory;

/**
 * Class ConfigurationFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class ConfigurationFactoryTest extends AbstractFactoryTest
{
    /**
     * Default configuration factory creation
     */
    public function testConfigurationFactoryCreation(): void
    {
        $factory = new ConfigurationFactory();
        $configuration = $factory($this->getContainer(), 'doctrine.configuration.orm_default');

        $this->assertInstanceOf(Configuration::class, $configuration);
    }

    /**
     * Test Named query exception
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function testRsmException(): void
    {
        $this->config['doctrine']['configuration']['orm_default']['named_native_queries'][] = [
            'name' => 'test',
            'rsm' => 'TestAssets\ResultSetMapping',
            'sql' => 'SHOW DATABASES;'
        ];

        $factory = new ConfigurationFactory();
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.configuration.orm_default');
    }
}
