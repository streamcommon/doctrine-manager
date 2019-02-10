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

namespace Streamcommon\Doctrine\Container\Interop\Factory;

use Doctrine\Common\{EventManager, EventSubscriber};
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Options\EventManager as EventManagerOptions;
use Streamcommon\Doctrine\Container\Interop\Exception\{RuntimeException};

/**
 * Class EventManagerFactory
 *
 * @package Streamcommon\Doctrine\Container\Interop\Factory
 */
class EventManagerFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new EventManagerOptions($this->getOptions($container, 'event_manager'));

        $eventManager = new EventManager();
        foreach ($options->getSubscribers() as $subscriber) {
            $subscriber = $container->get($subscriber);
            if (!($subscriber instanceof EventSubscriber)) {
                throw new RuntimeException(sprintf(
                    'Expected class instance of EventSubscriber, got %s',
                    is_object($subscriber) ? get_class($subscriber) : gettype($subscriber)
                ));
            }
            $eventManager->addEventSubscriber($subscriber);
        }
        $eventManager->addEventSubscriber($container->get('doctrine.entity_resolver.' . $options->getEntityResolver()));
        return $eventManager;
    }
}
