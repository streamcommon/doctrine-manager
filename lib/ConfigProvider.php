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

namespace Streamcommon\Doctrine\Manager;

/**
 * Class ConfigProvider
 *
 * @package Streamcommon\Doctrine\Manager
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => include __DIR__ . '/../config/dependencies.config.php',
            'doctrine' => include __DIR__ . '/../config/doctrine.config.php',
        ];
    }
}
