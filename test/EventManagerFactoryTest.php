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

use ArrayObject;
use Doctrine\Common\EventManager;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Exception\RuntimeException;
use Streamcommon\Doctrine\Container\Interop\Factory\EntityResolverFactory;
use Streamcommon\Doctrine\Container\Interop\Factory\EventManagerFactory;
use Streamcommon\Test\Doctrine\Container\Interop\TestAssets\TestEventSubscriber;

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

    /**
     * EventSubscriber Exception
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
