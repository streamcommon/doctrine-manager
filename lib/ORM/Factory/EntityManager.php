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

namespace Streamcommon\Doctrine\Manager\ORM\Factory;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\AbstractFactory;
use Streamcommon\Doctrine\Manager\Options\EntityManager as EntityManagerOptions;
use Streamcommon\Doctrine\Manager\ORM\EntityMangerDecorator;

/**
 * Class EntityManager
 *
 * @package Streamcommon\Doctrine\Manager\ORM\Factory
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/working-with-objects.html
 */
class EntityManager extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array<mixed>  $options
     * @return \Doctrine\ORM\EntityManagerInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new EntityManagerOptions($this->getOptions($container, 'entity_manager'));
        /** @var Connection $connection */
        $connection    = $container->get('doctrine.connection.' . $options->getConnection());
        $configuration = $container->get('doctrine.configuration.' . $options->getConfiguration());

        $em = \Doctrine\ORM\EntityManager::create($connection, $configuration, $connection->getEventManager());
        return new EntityMangerDecorator($em);
    }
}
