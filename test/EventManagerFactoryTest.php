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

use Doctrine\Common\EventManager;
use Streamcommon\Doctrine\Container\Interop\Factory\EventManagerFactory;

/**
 * Class EventManagerFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
 */
class EventManagerFactoryTest extends AbstractFactoryTest
{
    /**
     * Default event manager factory creation
     */
    public function testEventManagerFactoryCreation(): void
    {
        $factory = new EventManagerFactory();
        $eventManger = $factory($this->getContainer(), 'doctrine.event_manager.orm_default');

        $this->assertInstanceOf(EventManager::class, $eventManger);
    }
}
