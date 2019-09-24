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

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\Options\EntityManager as EntityManagerOptions;

/**
 * Class EntityManagerFactory
 *
 * @package Streamcommon\Doctrine\Manager\Factory
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/working-with-objects.html
 */
class EntityManagerFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new EntityManagerOptions($this->getOptions($container, 'entity_manager'));

        $connection = $container->get('doctrine.connection.' . $options->getConnection());
        $configuration = $container->get('doctrine.configuration.' . $options->getConfiguration());

        return EntityManager::create($connection, $configuration);
    }
}
