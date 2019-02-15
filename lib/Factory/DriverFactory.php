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

use Doctrine\Common\Annotations\{AnnotationReader, CachedReader, IndexedReader};
use Doctrine\Common\Persistence\Mapping\Driver\{AnnotationDriver, FileDriver, MappingDriverChain, MappingDriver};
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Options\Driver as DriverOptions;
use Streamcommon\Doctrine\Container\Interop\Exception\{RuntimeException};

/**
 * Class DriverFactory
 *
 * @package Streamcommon\Doctrine\Container\Interop\Factory
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/metadata-drivers.html#metadata-drivers
 */
class DriverFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return MappingDriver
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new DriverOptions($this->getOptions($container, 'driver'));

        $className = $options->getClassName();
        if ($container->has($className)) {
            $driver = $container->get($className);
        } elseif ($className === AnnotationDriver::class || is_subclass_of($className, AnnotationDriver::class)) {
            $cache = $container->get('doctrine.cache.' . $options->getCache());
            $reader = new CachedReader(new IndexedReader(new AnnotationReader()), $cache);
            $driver = new $className($reader, $options->getPaths());
        } elseif ($className === FileDriver::class || is_subclass_of($className, FileDriver::class)) {
            $driver = new $className($options->getPaths(), $options->getExtension());
            if ($options->getGlobalBasename() !== null && $driver instanceof FileDriver) {
                $driver->setGlobalBasename($options->getGlobalBasename());
            }
        } elseif (class_exists($className) === true) {
            $driver = new $className($options->getPaths());
        } else {
            throw new RuntimeException(sprintf('Cannot create driver with class name \'%s\'', $className));
        }

        if ($driver instanceof MappingDriverChain) {
            foreach ($options->getDrivers() as $alias => $className) {
                $driverFactory = new DriverFactory($alias);
                $driver->addDriver($driverFactory($container, $alias), $alias);
            }
        }
        return $driver;
    }
}
