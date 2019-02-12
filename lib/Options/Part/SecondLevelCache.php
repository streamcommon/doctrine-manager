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

namespace Streamcommon\Doctrine\Container\Interop\Options\Part;

use Streamcommon\Doctrine\Container\Interop\Options\Part\Cache\Region;
use Zend\Stdlib\AbstractOptions;

/**
 * Class SecondLevelCache
 *
 * @package Streamcommon\Doctrine\Container\Interop\Options\Part
 * @see http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/second-level-cache.html
 */
class SecondLevelCache extends AbstractOptions
{
    /** @var bool */
    protected $enabled = false;
    /** @var int */
    protected $defaultLifetime = 3600;
    /** @var int */
    protected $defaultLockLifetime = 60;
    /** @var null|string */
    protected $fileLockRegionDirectory = null;
    /** @var Region[] */
    protected $regions = [];

    /**
     * Get enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param bool $enabled
     * @return SecondLevelCache
     */
    public function setEnabled(bool $enabled): SecondLevelCache
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Get defaultLifetime
     *
     * @return int
     */
    public function getDefaultLifetime(): int
    {
        return $this->defaultLifetime;
    }

    /**
     * Set defaultLifetime
     *
     * @param int $defaultLifetime
     * @return SecondLevelCache
     */
    public function setDefaultLifetime(int $defaultLifetime): SecondLevelCache
    {
        $this->defaultLifetime = $defaultLifetime;
        return $this;
    }

    /**
     * Get defaultLockLifetime
     *
     * @return int
     */
    public function getDefaultLockLifetime(): int
    {
        return $this->defaultLockLifetime;
    }

    /**
     * Set defaultLockLifetime
     *
     * @param int $defaultLockLifetime
     * @return SecondLevelCache
     */
    public function setDefaultLockLifetime(int $defaultLockLifetime): SecondLevelCache
    {
        $this->defaultLockLifetime = $defaultLockLifetime;
        return $this;
    }

    /**
     * Get fileLockRegionDirectory
     *
     * @return string|null
     */
    public function getFileLockRegionDirectory(): ?string
    {
        return $this->fileLockRegionDirectory;
    }

    /**
     * Set fileLockRegionDirectory
     *
     * @param string|null $fileLockRegionDirectory
     * @return SecondLevelCache
     */
    public function setFileLockRegionDirectory(?string $fileLockRegionDirectory): SecondLevelCache
    {
        $this->fileLockRegionDirectory = $fileLockRegionDirectory;
        return $this;
    }

    /**
     * Get regions
     *
     * @return Region[]
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * Set regions
     *
     * @param mixed[] $regions
     * @return SecondLevelCache
     */
    public function setRegions(array $regions): SecondLevelCache
    {
        foreach ($regions as $key => $region) {
            if (is_array($region)) {
                $regions[$key] = $region = new Region($region);
            }
            if (!$region instanceof Region) {
                unset($regions[$key]);
            }
        }
        $this->regions = $regions;
        return $this;
    }
}
