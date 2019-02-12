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

use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Options\EntityResolver as EntityResolverOptions;

/**
 * Class EntityResolverFactory
 *
 * @package Streamcommon\Doctrine\Container\Interop\Factory
 */
class EntityResolverFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
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
