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

namespace Streamcommon\Doctrine\Manager\Options\Part;

use Zend\Stdlib\AbstractOptions;

/**
 * Class NamedQuery
 *
 * @package Streamcommon\Doctrine\Manager\Options\Part
 */
class NamedQuery extends AbstractOptions
{
    /** @var string */
    protected $name;
    /** @var string */
    protected $sql;

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return NamedQuery
     */
    public function setName(string $name): NamedQuery
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get sql
     *
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * Set sql
     *
     * @param string $sql
     * @return NamedQuery
     */
    public function setSql(string $sql): NamedQuery
    {
        $this->sql = $sql;
        return $this;
    }
}
