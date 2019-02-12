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

use Doctrine\ORM\Configuration;
use Streamcommon\Doctrine\Container\Interop\Factory\ConfigurationFactory;

/**
 * Class ConfigurationFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
 */
class ConfigurationFactoryTest extends AbstractFactoryTest
{
    /**
     * Default configuration factory creation
     */
    public function testConfigurationFactoryCreation(): void
    {
        $factory = new ConfigurationFactory();
        $entityResolver = $factory($this->getContainer(), 'doctrine.configuration.orm_default');

        $this->assertInstanceOf(Configuration::class, $entityResolver);
    }
}
