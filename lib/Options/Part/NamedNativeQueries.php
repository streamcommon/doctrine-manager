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

namespace Streamcommon\Doctrine\Manager\Options\Part;

use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Class NamedNativeQueries
 *
 * @package Streamcommon\Doctrine\Manager\Options\Part
 */
class NamedNativeQueries extends NamedQuery
{
    /** @var string|ResultSetMapping|null */
    protected $rsm;

    /**
     * Get rsm
     *
     * @return ResultSetMapping|string|null
     */
    public function getRsm()
    {
        return $this->rsm;
    }

    /**
     * Set rsm
     *
     * @param ResultSetMapping|string|null $rsm
     * @return NamedNativeQueries
     */
    public function setRsm($rsm): NamedNativeQueries
    {
        $this->rsm = $rsm;
        return $this;
    }
}
