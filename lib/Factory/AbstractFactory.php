<?php
/**
 * This file is part of the doctrine-container-manager package, a StreamCommon open software project.
 *
 * @copyright (c) 2019 StreamCommon Team
 * @see https://github.com/streamcommon/doctrine-container-manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Streamcommon\Doctrine\Manager\Factory;

use Psr\Container\ContainerInterface;
use Streamcommon\Factory\Container\Interop\{FactoryInterface, CallableFactoryTrait};
use Streamcommon\Doctrine\Manager\Exception\{RuntimeException};

use function sprintf;

/**
 * Class AbstractFactory
 *
 * @package Streamcommon\Doctrine\Manager\Factory
 */
abstract class AbstractFactory implements FactoryInterface
{
    use CallableFactoryTrait;

    /**
     * AbstractFactory constructor.
     *
     * @param string $name
     */
    public function __construct(string $name = 'orm_default')
    {
        $this->name = $name;
    }

    /**
     * Gets options from configuration based on name.
     *
     * @param ContainerInterface $container
     * @param string $key
     * @param string|null $ormName
     * @return array
     * @throws RuntimeException
     */
    public function getOptions(ContainerInterface $container, string $key, string $ormName = null): array
    {
        if ($ormName === null) {
            $ormName = $this->name;
        }
        $config = $container->has('config') ? $container->get('config') : [];
        $doctrineConfig = !empty($config['doctrine']) ? $config['doctrine'] : [];
        $ormConfig = !empty($doctrineConfig[$key]) ? $doctrineConfig[$key] : [];

        if (empty($ormConfig[$ormName])) {
            throw new RuntimeException(sprintf(
                'Options with name %s could not be found in doctrine.%s.',
                $ormName,
                $key
            ));
        }

        return $ormConfig[$ormName];
    }
}
