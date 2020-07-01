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

use Doctrine\Persistence\Mapping\Driver\MappingDriver;
use Streamcommon\Doctrine\Manager\Common\Factory\Driver as DriverFactory;
use Streamcommon\Doctrine\Manager\Exception\RuntimeException;

/**
 * Class DriverFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class DriverFactoryTest extends AbstractFactoryTest
{
    /**
     * Default entity resolver factory creation
     *
     * @return void
     */
    public function testEntityResolverFactoryCreation(): void
    {
        $factory = new DriverFactory('orm_default');
        $driver  = $factory($this->getContainer(), 'doctrine.driver.orm_default');

        $this->assertInstanceOf(MappingDriver::class, $driver);
    }

    /**
     * Test Exception
     *
     * @return void
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testRuntimeException(): void
    {
        $this->config['doctrine']['driver']['orm_default']['drivers']['NotFoundA'] = 'NotFoundA';

        $factory = new DriverFactory('orm_default');
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.driver.orm_default');
    }

    /**
     * Test Exception
     *
     * @return void
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testDriverException(): void
    {
        $this->config['doctrine']['driver']['orm_default']['drivers']['NotFoundA'] = 'NotFoundA';
        $this->config['doctrine']['driver']['NotFoundA']                           = ['class_name' => 'NotFoundA'];

        $factory = new DriverFactory('orm_default');
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.driver.orm_default');
    }

    /**
     * Test NULL Exception
     *
     * @return void
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function testDriverNullException(): void
    {
        $this->config['doctrine']['driver']['orm_default']['drivers']['NotFoundA'] = 'NotFoundA';
        $this->config['doctrine']['driver']['NotFoundA']                           = ['class_name' => null];

        $factory = new DriverFactory('orm_default');
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.driver.orm_default');
    }
}
