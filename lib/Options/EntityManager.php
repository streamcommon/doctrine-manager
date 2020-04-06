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

use Laminas\Stdlib\AbstractOptions;

/**
 * Class EntityManager
 *
 * @package Streamcommon\Doctrine\Manager\Options
 */
class EntityManager extends AbstractOptions
{
    /** @var string */
    protected $connection = 'orm_default';
    /** @var string */
    protected $configuration = 'orm_default';

    /**
     * Get connection
     *
     * @return string
     */
    public function getConnection(): string
    {
        return $this->connection;
    }

    /**
     * Set connection
     *
     * @param string $connection
     * @return EntityManager
     */
    public function setConnection(string $connection): EntityManager
    {
        $this->connection = $connection;
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
     * @return EntityManager
     */
    public function setConfiguration(string $configuration): EntityManager
    {
        $this->configuration = $configuration;
        return $this;
    }
}
