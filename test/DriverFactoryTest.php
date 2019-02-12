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
        $entityResolver = $factory($this->getContainer(), 'doctrine.driver.orm_default');

        $this->assertInstanceOf(MappingDriver::class, $entityResolver);
    }
}
