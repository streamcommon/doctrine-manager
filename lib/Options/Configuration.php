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

namespace Streamcommon\Doctrine\Container\Interop\Options;

use Streamcommon\Doctrine\Container\Interop\Options\Part\{NamedQuery, NamedNativeQueries, SecondLevelCache};
use Streamcommon\Doctrine\Container\Interop\Exception\{InvalidArgumentException};
use Zend\Stdlib\AbstractOptions;

/**
 * Class Configuration
 *
 * @package Streamcommon\Doctrine\Container\Interop\Options
 *
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html
 * @link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/second-level-cache.html
 */
class Configuration extends AbstractOptions
{
    /** @var string */
    protected $metadataCache = 'array';
    /** @var string */
    protected $queryCache = 'array';
    /** @var string */
    protected $resultCache = 'array';
    /** @var string */
    protected $hydrationCache = 'array';
    /** @var string */
    protected $driver = 'orm_default';
    /** @var bool */
    protected $autoGenerateProxiesClasses = true;
    /** @var string */
    protected $proxyDir = 'data/doctrine/orm/proxy';
    /** @var string */
    protected $proxyNamespace = 'Streamcommon\Doctrine\Container\Interop\Proxy';
    /** @var array */
    protected $entityNamespaces = [];
    /** @var array */
    protected $datetimeFunctions = [];
    /** @var array */
    protected $customStringFunctions = [];
    /** @var array */
    protected $customNumericFunctions = [];
    /** @var array */
    protected $filters = [];
    /** @var NamedQuery[] */
    protected $namedQueries = [];
    /** @var NamedNativeQueries[] */
    protected $namedNativeQueries = [];
    /** @var array */
    protected $customHydrationModes = [];
    /** @var string|null */
    protected $namingStrategy = null;
    /** @var string|null */
    protected $quoteStrategy = null;
    /** @var string|null */
    protected $defaultRepositoryClassName = null;
    /** @var string|null */
    protected $repositoryFactory = null;
    /** @var string|null */
    protected $classMetadataFactoryName = null;
    /** @var string|null */
    protected $entityListenerResolver = null;
    /** @var SecondLevelCache */
    protected $secondLevelCache;
    /** @var string|null */
    protected $sqlLogger = null;

    /**
     * Configuration constructor.
     *
     * @param null|array $options
     */
    public function __construct(?array $options = null)
    {
        $this->secondLevelCache = new SecondLevelCache();
        parent::__construct($options);
    }

    /**
     * Get metadataCache
     *
     * @return string
     */
    public function getMetadataCache(): string
    {
        return $this->metadataCache;
    }

    /**
     * Set metadataCache
     *
     * @param string $metadataCache
     * @return Configuration
     */
    public function setMetadataCache(string $metadataCache): Configuration
    {
        $this->metadataCache = $metadataCache;
        return $this;
    }

    /**
     * Get queryCache
     *
     * @return string
     */
    public function getQueryCache(): string
    {
        return $this->queryCache;
    }

    /**
     * Set queryCache
     *
     * @param string $queryCache
     * @return Configuration
     */
    public function setQueryCache(string $queryCache): Configuration
    {
        $this->queryCache = $queryCache;
        return $this;
    }

    /**
     * Get resultCache
     *
     * @return string
     */
    public function getResultCache(): string
    {
        return $this->resultCache;
    }

    /**
     * Set resultCache
     *
     * @param string $resultCache
     * @return Configuration
     */
    public function setResultCache(string $resultCache): Configuration
    {
        $this->resultCache = $resultCache;
        return $this;
    }

    /**
     * Get hydrationCache
     *
     * @return string
     */
    public function getHydrationCache(): string
    {
        return $this->hydrationCache;
    }

    /**
     * Set hydrationCache
     *
     * @param string $hydrationCache
     * @return Configuration
     */
    public function setHydrationCache(string $hydrationCache): Configuration
    {
        $this->hydrationCache = $hydrationCache;
        return $this;
    }

    /**
     * Get driver
     *
     * @return string
     */
    public function getDriver(): string
    {
        return $this->driver;
    }

    /**
     * Set driver
     *
     * @param string $driver
     * @return Configuration
     */
    public function setDriver(string $driver): Configuration
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * Get autoGenerateProxiesClasses
     *
     * @return bool
     */
    public function isAutoGenerateProxiesClasses(): bool
    {
        return $this->autoGenerateProxiesClasses;
    }

    /**
     * Set autoGenerateProxiesClasses
     *
     * @param bool $autoGenerateProxiesClasses
     * @return Configuration
     */
    public function setAutoGenerateProxiesClasses(bool $autoGenerateProxiesClasses): Configuration
    {
        $this->autoGenerateProxiesClasses = $autoGenerateProxiesClasses;
        return $this;
    }

    /**
     * Get proxyDir
     *
     * @return string
     */
    public function getProxyDir(): string
    {
        return $this->proxyDir;
    }

    /**
     * Set proxyDir
     *
     * @param string $proxyDir
     * @return Configuration
     */
    public function setProxyDir(string $proxyDir): Configuration
    {
        $this->proxyDir = $proxyDir;
        return $this;
    }

    /**
     * Get proxyNamespace
     *
     * @return string
     */
    public function getProxyNamespace(): string
    {
        return $this->proxyNamespace;
    }

    /**
     * Set proxyNamespace
     *
     * @param string $proxyNamespace
     * @return Configuration
     */
    public function setProxyNamespace(string $proxyNamespace): Configuration
    {
        $this->proxyNamespace = $proxyNamespace;
        return $this;
    }

    /**
     * Get entityNamespaces
     *
     * @return array
     */
    public function getEntityNamespaces(): array
    {
        return $this->entityNamespaces;
    }

    /**
     * Set entityNamespaces
     *
     * @param array $entityNamespaces
     * @return Configuration
     */
    public function setEntityNamespaces(array $entityNamespaces): Configuration
    {
        $this->entityNamespaces = $entityNamespaces;
        return $this;
    }

    /**
     * Get datetimeFunctions
     *
     * @return array
     */
    public function getDatetimeFunctions(): array
    {
        return $this->datetimeFunctions;
    }

    /**
     * Set datetimeFunctions
     *
     * @param array $datetimeFunctions
     * @return Configuration
     */
    public function setDatetimeFunctions(array $datetimeFunctions): Configuration
    {
        $this->datetimeFunctions = $datetimeFunctions;
        return $this;
    }

    /**
     * Get customStringFunctions
     *
     * @return array
     */
    public function getCustomStringFunctions(): array
    {
        return $this->customStringFunctions;
    }

    /**
     * Set customStringFunctions
     *
     * @param array $customStringFunctions
     * @return Configuration
     */
    public function setCustomStringFunctions(array $customStringFunctions): Configuration
    {
        $this->customStringFunctions = $customStringFunctions;
        return $this;
    }

    /**
     * Get customNumericFunctions
     *
     * @return array
     */
    public function getCustomNumericFunctions(): array
    {
        return $this->customNumericFunctions;
    }

    /**
     * Set customNumericFunctions
     *
     * @param array $customNumericFunctions
     * @return Configuration
     */
    public function setCustomNumericFunctions(array $customNumericFunctions): Configuration
    {
        $this->customNumericFunctions = $customNumericFunctions;
        return $this;
    }

    /**
     * Get filters
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Set filters
     *
     * @param array $filters
     * @return Configuration
     */
    public function setFilters(array $filters): Configuration
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Get namedQueries
     *
     * @return NamedQuery[]
     */
    public function getNamedQueries(): array
    {
        return $this->namedQueries;
    }

    /**
     * Set namedQueries
     *
     * @param array $namedQueries
     * @return Configuration
     */
    public function setNamedQueries(array $namedQueries): Configuration
    {
        $this->namedQueries = array_map(function ($item) {
            return new NamedQuery($item);
        }, $namedQueries);
        return $this;
    }

    /**
     * Get namedNativeQueries
     *
     * @return NamedNativeQueries[]
     */
    public function getNamedNativeQueries(): array
    {
        return $this->namedNativeQueries;
    }

    /**
     * Set namedNativeQueries
     *
     * @param array $namedNativeQueries
     * @return Configuration
     */
    public function setNamedNativeQueries(array $namedNativeQueries): Configuration
    {
        $this->namedNativeQueries = array_map(function ($item) {
            return new NamedNativeQueries($item);
        }, $namedNativeQueries);
        return $this;
    }

    /**
     * Get customHydrationModes
     *
     * @return array
     */
    public function getCustomHydrationModes(): array
    {
        return $this->customHydrationModes;
    }

    /**
     * Set customHydrationModes
     *
     * @param array $customHydrationModes
     * @return Configuration
     */
    public function setCustomHydrationModes(array $customHydrationModes): Configuration
    {
        $this->customHydrationModes = $customHydrationModes;
        return $this;
    }

    /**
     * Get namingStrategy
     *
     * @return string|null
     */
    public function getNamingStrategy(): ?string
    {
        return $this->namingStrategy;
    }

    /**
     * Set namingStrategy
     *
     * @param string|null $namingStrategy
     * @return Configuration
     */
    public function setNamingStrategy(?string $namingStrategy): Configuration
    {
        $this->namingStrategy = $namingStrategy;
        return $this;
    }

    /**
     * Get quoteStrategy
     *
     * @return string|null
     */
    public function getQuoteStrategy()
    {
        return $this->quoteStrategy;
    }

    /**
     * Set quoteStrategy
     *
     * @param string|null $quoteStrategy
     * @return Configuration
     */
    public function setQuoteStrategy($quoteStrategy): Configuration
    {
        $this->quoteStrategy = $quoteStrategy;
        return $this;
    }

    /**
     * Get defaultRepositoryClassName
     *
     * @return string|null
     */
    public function getDefaultRepositoryClassName(): ?string
    {
        return $this->defaultRepositoryClassName;
    }

    /**
     * Set defaultRepositoryClassName
     *
     * @param string|null $defaultRepositoryClassName
     * @return Configuration
     */
    public function setDefaultRepositoryClassName(?string $defaultRepositoryClassName): Configuration
    {
        $this->defaultRepositoryClassName = $defaultRepositoryClassName;
        return $this;
    }

    /**
     * Get repositoryFactory
     *
     * @return string|null
     */
    public function getRepositoryFactory(): ?string
    {
        return $this->repositoryFactory;
    }

    /**
     * Set repositoryFactory
     *
     * @param string|null $repositoryFactory
     * @return Configuration
     */
    public function setRepositoryFactory(?string $repositoryFactory): Configuration
    {
        $this->repositoryFactory = $repositoryFactory;
        return $this;
    }

    /**
     * Get classMetadataFactoryName
     *
     * @return string|null
     */
    public function getClassMetadataFactoryName(): ?string
    {
        return $this->classMetadataFactoryName;
    }

    /**
     * Set classMetadataFactoryName
     *
     * @param string|null $classMetadataFactoryName
     * @return Configuration
     */
    public function setClassMetadataFactoryName(?string $classMetadataFactoryName): Configuration
    {
        $this->classMetadataFactoryName = $classMetadataFactoryName;
        return $this;
    }

    /**
     * Get entityListenerResolver
     *
     * @return string|null
     */
    public function getEntityListenerResolver(): ?string
    {
        return $this->entityListenerResolver;
    }

    /**
     * Set entityListenerResolver
     *
     * @param string|null $entityListenerResolver
     * @return Configuration
     */
    public function setEntityListenerResolver(?string $entityListenerResolver): Configuration
    {
        $this->entityListenerResolver = $entityListenerResolver;
        return $this;
    }

    /**
     * Get secondLevelCache
     *
     * @return Part\SecondLevelCache
     */
    public function getSecondLevelCache(): Part\SecondLevelCache
    {
        return $this->secondLevelCache;
    }

    /**
     * Set secondLevelCache
     *
     * @param SecondLevelCache|array $secondLevelCache
     * @return Configuration
     */
    public function setSecondLevelCache($secondLevelCache): Configuration
    {
        if (is_array($secondLevelCache)) {
            $secondLevelCache = new SecondLevelCache($secondLevelCache);
        }
        if (!$secondLevelCache instanceof SecondLevelCache) {
            throw new InvalidArgumentException(sprintf(
                'Expected SecondLevelCache instance, got %s',
                is_object($secondLevelCache) ? get_class($secondLevelCache) : gettype($secondLevelCache)
            ));
        }
        $this->secondLevelCache = $secondLevelCache;
        return $this;
    }

    /**
     * Get sqlLogger
     *
     * @return string|null
     */
    public function getSqlLogger(): ?string
    {
        return $this->sqlLogger;
    }

    /**
     * Set sqlLogger
     *
     * @param string|null $sqlLogger
     * @return Configuration
     */
    public function setSqlLogger(?string $sqlLogger): Configuration
    {
        $this->sqlLogger = $sqlLogger;
        return $this;
    }
}
