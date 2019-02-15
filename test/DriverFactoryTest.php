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

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Streamcommon\Doctrine\Container\Interop\Factory\DriverFactory;
use Streamcommon\Doctrine\Container\Interop\Exception\RuntimeException;

/**
 * Class DriverFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
 */
class DriverFactoryTest extends AbstractFactoryTest
{
    /**
     * Default entity resolver factory creation
     */
    public function testEntityResolverFactoryCreation(): void
    {
        $factory = new DriverFactory();
        $driver = $factory($this->getContainer(), 'doctrine.driver.orm_default');

        $this->assertInstanceOf(MappingDriver::class, $driver);
    }

    /**
     * Test Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testRuntimeException(): void
    {
        $this->config['doctrine']['driver']['orm_default']['drivers']['NotFoundA'] = 'NotFoundA';

        $factory = new DriverFactory();
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.driver.orm_default');
    }

    /**
     * Test Exception
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testDriverException(): void
    {
        $this->config['doctrine']['driver']['orm_default']['drivers']['NotFoundA'] = 'NotFoundA';
        $this->config['doctrine']['driver']['NotFoundA'] = ['class_name' => 'NotFoundA'];

        $factory = new DriverFactory();
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.driver.orm_default');
    }
}
