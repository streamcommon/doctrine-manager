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

use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\AbstractFactory;
use Streamcommon\Doctrine\Manager\Options\EntityResolver as EntityResolverOptions;

/**
 * Class EntityResolver
 *
 * @package Streamcommon\Doctrine\Manager\ORM\Factory
 */
class EntityResolver extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     * @return ResolveTargetEntityListener
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new EntityResolverOptions($this->getOptions($container, 'entity_resolver'));

        $entityResolver = new ResolveTargetEntityListener();
        foreach ($options->getResolvers() as $originalEntity => $newEntity) {
            $entityResolver->addResolveTargetEntity($originalEntity, $newEntity, []);
        }
        return $entityResolver;
    }
}
