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

use Zend\Stdlib\AbstractOptions;

/**
 * Class Cache
 *
 * @package Streamcommon\Doctrine\Container\Interop\Options
 */
class Cache extends AbstractOptions
{
    /** @var string|null */
    protected $className;
    /** @var string|null */
    protected $namespace;
    /** @var string|null */
    protected $instance;
    /** @var string|null */
    protected $path;

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
     * @return Cache
     */
    public function setClassName(?string $className): Cache
    {
        $this->className = $className;
        return $this;
    }

    /**
     * Get namespace
     *
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * Set namespace
     *
     * @param string|null $namespace
     * @return Cache
     */
    public function setNamespace(?string $namespace): Cache
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Get instance
     *
     * @return string|null
     */
    public function getInstance(): ?string
    {
        return $this->instance;
    }

    /**
     * Set instance
     *
     * @param string|null $instance
     * @return Cache
     */
    public function setInstance(?string $instance): Cache
    {
        $this->instance = $instance;
        return $this;
    }

    /**
     * Get path
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param string|null $path
     * @return Cache
     */
    public function setPath(?string $path): Cache
    {
        $this->path = $path;
        return $this;
    }
}
