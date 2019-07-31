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

namespace Streamcommon\Doctrine\Manager\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class Driver
 *
 * @package Streamcommon\Doctrine\Manager\Options
 */
class Driver extends AbstractOptions
{
    /** @var string|null */
    protected $className;
    /** @var array */
    protected $paths = [];
    /** @var string|null */
    protected $extension;
    /** @var string */
    protected $cache = 'array';
    /** @var array */
    protected $drivers = [];
    /** @var string|null */
    protected $globalBasename;

    /**
     * Get className
     *
     * @return string|null
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * Set className
     *
     * @param string|null $className
     * @return Driver
     */
    public function setClassName(?string $className): Driver
    {
        $this->className = $className;
        return $this;
    }

    /**
     * Get paths
     *
     * @return array
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Set paths
     *
     * @param array $paths
     * @return Driver
     */
    public function setPaths(array $paths): Driver
    {
        $this->paths = $paths;
        return $this;
    }

    /**
     * Get extension
     *
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * Set extension
     *
     * @param string|null $extension
     * @return Driver
     */
    public function setExtension(?string $extension): Driver
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * Get cache
     *
     * @return string
     */
    public function getCache(): string
    {
        return $this->cache;
    }

    /**
     * Set cache
     *
     * @param string $cache
     * @return Driver
     */
    public function setCache(string $cache): Driver
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * Get drivers
     *
     * @return array
     */
    public function getDrivers(): array
    {
        return $this->drivers;
    }

    /**
     * Set drivers
     *
     * @param array $drivers
     * @return Driver
     */
    public function setDrivers(array $drivers): Driver
    {
        $this->drivers = $drivers;
        return $this;
    }

    /**
     * Get globalBasename
     *
     * @return string|null
     */
    public function getGlobalBasename(): ?string
    {
        return $this->globalBasename;
    }

    /**
     * Set globalBasename
     *
     * @param string|null $globalBasename
     * @return Driver
     */
    public function setGlobalBasename(?string $globalBasename): Driver
    {
        $this->globalBasename = $globalBasename;
        return $this;
    }
}
