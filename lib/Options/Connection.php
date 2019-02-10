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

use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Streamcommon\Doctrine\Container\Interop\Exception\{InvalidArgumentException};
use Streamcommon\Doctrine\Container\Interop\Options\Part\{ConnectionParams};
use Zend\Stdlib\AbstractOptions;

/**
 * Class Connection
 *
 * @package Streamcommon\Doctrine\Container\Interop\Options
 */
class Connection extends AbstractOptions
{
    /** @var string */
    protected $driverClassName = Driver::class;
    /** @var string|null */
    protected $wrapperClassName;
    /** @var string|null */
    protected $pdoClassName;
    /** @var ConnectionParams */
    protected $params;
    /** @var string */
    protected $configuration = 'orm_default';
    /** @var string */
    protected $eventManager = 'orm_default';
    /** @var array */
    protected $typeMapping = [];
    /** @var array */
    protected $commentedTypes = [];

    /**
     * Connection constructor.
     *
     * @param null|array $options
     */
    public function __construct(?array $options = null)
    {
        $this->params = new ConnectionParams();
        parent::__construct($options);
    }

    /**
     * Get driverClassName
     *
     * @return string
     */
    public function getDriverClassName(): string
    {
        return $this->driverClassName;
    }

    /**
     * Set driverClassName
     *
     * @param string $driverClassName
     * @return Connection
     */
    public function setDriverClassName(string $driverClassName): Connection
    {
        $this->driverClassName = $driverClassName;
        return $this;
    }

    /**
     * Get wrapperClassName
     *
     * @return string|null
     */
    public function getWrapperClassName(): ?string
    {
        return $this->wrapperClassName;
    }

    /**
     * Set wrapperClassName
     *
     * @param string|null $wrapperClassName
     * @return Connection
     */
    public function setWrapperClassName(?string $wrapperClassName): Connection
    {
        $this->wrapperClassName = $wrapperClassName;
        return $this;
    }

    /**
     * Get pdoClassName
     *
     * @return string|null
     */
    public function getPdoClassName(): ?string
    {
        return $this->pdoClassName;
    }

    /**
     * Set pdoClassName
     *
     * @param string|null $pdoClassName
     * @return Connection
     */
    public function setPdoClassName(?string $pdoClassName): Connection
    {
        $this->pdoClassName = $pdoClassName;
        return $this;
    }

    /**
     * Get params
     *
     * @return ConnectionParams
     */
    public function getParams(): ConnectionParams
    {
        return $this->params;
    }

    /**
     * Set params
     *
     * @param ConnectionParams|array $params
     * @return Connection
     */
    public function setParams($params): Connection
    {
        if (is_array($params)) {
            $params = new ConnectionParams($params);
        }
        if (!$params instanceof ConnectionParams) {
            throw new InvalidArgumentException(sprintf(
                'Expected ConnectionParams instance, got %s',
                is_object($params) ? get_class($params) : gettype($params)
            ));
        }
        $this->params = $params;
        return $this;
    }

    /**
     * Get configuration
     *
     * @return string
     */
    public function getConfiguration(): string
    {
        return $this->configuration;
    }

    /**
     * Set configuration
     *
     * @param string $configuration
     * @return Connection
     */
    public function setConfiguration(string $configuration): Connection
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * Get eventManager
     *
     * @return string
     */
    public function getEventManager(): string
    {
        return $this->eventManager;
    }

    /**
     * Set eventManager
     *
     * @param string $eventManager
     * @return Connection
     */
    public function setEventManager(string $eventManager): Connection
    {
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * Get typeMapping
     *
     * @return array
     */
    public function getTypeMapping(): array
    {
        return $this->typeMapping;
    }

    /**
     * Set typeMapping
     *
     * @param array $typeMapping
     * @return Connection
     */
    public function setTypeMapping(array $typeMapping): Connection
    {
        $this->typeMapping = $typeMapping;
        return $this;
    }

    /**
     * Get commentedTypes
     *
     * @return array
     */
    public function getCommentedTypes(): array
    {
        return $this->commentedTypes;
    }

    /**
     * Set commentedTypes
     *
     * @param array $commentedTypes
     * @return Connection
     */
    public function setCommentedTypes(array $commentedTypes): Connection
    {
        $this->commentedTypes = $commentedTypes;
        return $this;
    }
}
