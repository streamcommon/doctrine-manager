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

use ArrayObject;
use Doctrine\Common\EventManager;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\Exception\RuntimeException;
use Streamcommon\Doctrine\Manager\Factory\EntityResolverFactory;
use Streamcommon\Doctrine\Manager\Factory\EventManagerFactory;
use Streamcommon\Test\Doctrine\Manager\TestAssets\TestEventSubscriber;

/**
 * Class EventManagerFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class EventManagerFactoryTest extends AbstractFactoryTest
{
    /**
     * Default event manager factory creation
     *
     * @return void
     */
    public function testEventManagerFactoryCreation(): void
    {
        $factory     = new EventManagerFactory();
        $eventManger = $factory($this->getContainer(), 'doctrine.event_manager.orm_default');

        $this->assertInstanceOf(EventManager::class, $eventManger);
    }

    /**
     * EventSubscriber Exception
     *
     * @return void
     */
    public function testEventManagerFactoryException(): void
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->has('config')->willReturn(true);
        $container->get('config')->willReturn($this->config);
        $container->get(TestEventSubscriber::class)->willReturn(new ArrayObject());
        $container->get('doctrine.entity_resolver.orm_default')->willReturn(call_user_func_array(
            new EntityResolverFactory(),
            [
                $container->reveal(),
                'doctrine.entity_resolver.orm_default'
            ]
        ));

        $this->expectException(RuntimeException::class);
        $factory = new EventManagerFactory();
        $factory($container->reveal(), 'doctrine.event_manager.orm_default');
    }
}
