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

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Cache\{RegionsConfiguration, DefaultCacheFactory, CacheConfiguration};
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\Options\Configuration as ConfigurationOptions;
use Streamcommon\Doctrine\Manager\Exception\{RuntimeException};

use function is_object;
use function get_class;
use function gettype;
use function sprintf;
use function is_string;

/**
 * Class ConfigurationFactory
 *
 * @package Streamcommon\Doctrine\Manager\Factory
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/configuration.html#configuration
 */
class ConfigurationFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return Configuration
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

        $secondLevelCacheOptions = $options->getSecondLevelCache();
        if ($secondLevelCacheOptions->isEnabled()) {
            $regionsConfiguration = new RegionsConfiguration(
                $secondLevelCacheOptions->getDefaultLifetime(),
                $secondLevelCacheOptions->getDefaultLockLifetime()
            );

            foreach ($secondLevelCacheOptions->getRegions() as $region) {
                if ($region->getName() === null) {
                    continue;
                }
                $regionsConfiguration->setLifetime($region->getName(), $region->getLifetime());
                $regionsConfiguration->setLockLifetime($region->getName(), $region->getLockLifetime());
            }

            $cache = new ArrayCache();
            if ($configuration->getResultCacheImpl() !== null) {
                $cache = $configuration->getResultCacheImpl();
            }
            $cacheFactory = new DefaultCacheFactory($regionsConfiguration, $cache);
            if ($secondLevelCacheOptions->getFileLockRegionDirectory() !== null) {
                $cacheFactory->setFileLockRegionDirectory($secondLevelCacheOptions->getFileLockRegionDirectory());
            }

            $cacheConfiguration = new CacheConfiguration();
            $cacheConfiguration->setCacheFactory($cacheFactory);
            $cacheConfiguration->setRegionsConfiguration($regionsConfiguration);

            $configuration->setSecondLevelCacheEnabled();
            $configuration->setSecondLevelCacheConfiguration($cacheConfiguration);
        }
        return $configuration;
    }
}
