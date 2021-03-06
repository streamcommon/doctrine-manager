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

namespace Streamcommon\Test\Doctrine\Manager\TestAssets;

use Doctrine\Common\EventSubscriber;

/**
 * Class TestEventSubscriber
 *
 * @package Streamcommon\Test\Doctrine\Manager\TestAssets
 */
class TestEventSubscriber implements EventSubscriber
{
    /**
     * Return event
     *
     * @return array|string[]
     */
    public function getSubscribedEvents():array
    {
        return ['test'];
    }
}
