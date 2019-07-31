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

namespace Streamcommon\Doctrine\Manager\Factory;

use Doctrine\Common\{EventManager, EventSubscriber};
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\Options\EventManager as EventManagerOptions;
use Streamcommon\Doctrine\Manager\Exception\{RuntimeException};

use function is_object;
use function get_class;
use function gettype;
use function sprintf;

/**
 * Class EventManagerFactory
 *
 * @package Streamcommon\Doctrine\Manager\Factory
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/events.html
 */
class EventManagerFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return EventManager
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
