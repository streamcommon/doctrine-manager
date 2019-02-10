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

use Doctrine\ORM\Configuration;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Options\Configuration as ConfigurationOptions;
use Streamcommon\Doctrine\Container\Interop\Exception\{RuntimeException};

/**
 * Class ConfigurationFactory
 *
 * @package Streamcommon\Doctrine\Container\Interop\Factory
 */
class ConfigurationFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return object
     * @throws ORMException
     * @throws RuntimeException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new ConfigurationOptions($this->getOptions($container, 'configuration'));

        $configuration = new Configuration();
        $configuration->setProxyDir($options->getProxyDir());
        $configuration->setProxyNamespace($options->getProxyNamespace());
        $configuration->setAutoGenerateProxyClasses($options->isAutoGenerateProxiesClasses());
        $configuration->setEntityNamespaces($options->getEntityNamespaces());
        $configuration->setCustomDatetimeFunctions($options->getCustomHydrationModes());
        $configuration->setCustomNumericFunctions($options->getCustomNumericFunctions());
        $configuration->setCustomStringFunctions($options->getCustomStringFunctions());
        $configuration->setCustomHydrationModes($options->getCustomHydrationModes());

        foreach ($options->getNamedQueries() as $query) {
            $configuration->addNamedQuery($query->getName(), $query->getSql());
        }
        foreach ($options->getNamedNativeQueries() as $query) {
            $rsm = $query->getRsm();
            if (is_string($rsm)) {
                if ($container->has($rsm)) {
                    $rsm = $container->get($rsm);
                } elseif (class_exists($rsm)) {
                    $rsm = new $rsm;
                } else {
                    throw new RuntimeException(sprintf(
                        '%s variable must be instance of Doctrine\ORM\Query\ResultSetMapping',
                        is_object($rsm) ? get_class($rsm) : gettype($rsm)
                    ));
                }
            }
            $configuration->addNamedNativeQuery($query->getName(), $query->getSql(), $rsm);
        }
        foreach ($options->getFilters() as $name => $filter) {
            $configuration->addFilter($name, $filter);
        }

        $configuration->setMetadataCacheImpl($container->get('doctrine.cache.' . $options->getMetadataCache()));
        $configuration->setQueryCacheImpl($container->get('doctrine.cache.' . $options->getQueryCache()));
        $configuration->setResultCacheImpl($container->get('doctrine.cache.' . $options->getResultCache()));
        $configuration->setHydrationCacheImpl($container->get('doctrine.cache.' . $options->getHydrationCache()));
        $configuration->setMetadataDriverImpl($container->get('doctrine.driver.' . $options->getDriver()));

        if ($options->getClassMetadataFactoryName() !== null) {
            $configuration->setClassMetadataFactoryName($options->getClassMetadataFactoryName());
        }
        if ($options->getNamingStrategy() !== null) {
            $configuration->setNamingStrategy($container->get($options->getNamingStrategy()));
        }
        if ($options->getRepositoryFactory() !== null) {
            $configuration->setRepositoryFactory($container->get($options->getRepositoryFactory()));
        }
        if ($options->getEntityListenerResolver() !== null) {
            $configuration->setEntityListenerResolver($container->get($options->getEntityListenerResolver()));
        }
        if ($options->getDefaultRepositoryClassName() !== null) {
            $configuration->setDefaultRepositoryClassName($options->getDefaultRepositoryClassName());
        }
        if ($options->getSqlLogger() !== null) {
            $configuration->setSQLLogger($container->get($options->getSqlLogger()));
        }

//        $secondLevelCacheOptions = $options->getSecondLevelCache();
//        if ($secondLevelCacheOptions->isEnabled()) {
//            // todo configure
//        }
        return $configuration;
    }
}
