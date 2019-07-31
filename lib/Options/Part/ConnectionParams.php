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

use Streamcommon\Excess\Configuration\DbConnection;

/**
 * Class ConnectionParams
 *
 * @package Streamcommon\Doctrine\Manager\Options\Part
 */
class ConnectionParams extends DbConnection
{
    /** @var string|null */
    protected $platform;

    /**
     * Get platform
     *
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * Set platform
     *
     * @param string|null $platform
     * @return ConnectionParams
     */
    public function setPlatform(?string $platform): ConnectionParams
    {
        $this->platform = $platform;
        return $this;
    }
}
