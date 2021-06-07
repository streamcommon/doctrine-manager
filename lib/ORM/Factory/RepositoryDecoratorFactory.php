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

use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\AbstractFactory;

/**
 * Class RepositoryDecoratorFactory
 *
 * @package Streamcommon\Doctrine\Manager\ORM\Factory
 */
class RepositoryDecoratorFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array<mixed>  $options
     * @return \Streamcommon\Doctrine\Manager\ORM\RepositoryDecoratorFactory
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        return new \Streamcommon\Doctrine\Manager\ORM\RepositoryDecoratorFactory(
            $container->get('doctrine.entity_manager.' . $this->name)
        );
    }
}
