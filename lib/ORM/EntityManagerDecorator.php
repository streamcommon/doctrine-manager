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

namespace Streamcommon\Doctrine\Manager\ORM;

use Doctrine\ORM\EntityManager;

/**
 * Class EntityMangerDecorator
 *
 * @package Streamcommon\Doctrine\Manager\ORM
 * @codeCoverageIgnore
 */
class EntityManagerDecorator extends \Doctrine\ORM\Decorator\EntityManagerDecorator implements
    EntityManagerDecoratorInterface
{
    /**
     * {@inheritDoc}
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function reset()
    {
        $this->wrapped = EntityManager::create(
            $this->wrapped->getConnection(),
            $this->wrapped->getConfiguration(),
            $this->wrapped->getEventManager()
        );
    }
}
