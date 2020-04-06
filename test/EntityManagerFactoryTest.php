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

namespace Streamcommon\Test\Doctrine\Manager;

use Doctrine\ORM\EntityManager;
use Streamcommon\Doctrine\Manager\ORM\Factory\EntityManager as EntityManagerFactory;

/**
 * Class EntityManagerFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class EntityManagerFactoryTest extends AbstractFactoryTest
{
    /**
     * Default entity resolver factory creation
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function testEntityManagerFactoryCreation(): void
    {
        $factory       = new EntityManagerFactory('orm_default');
        $entityManager = $factory($this->getContainer(), 'doctrine.entity_manager.orm_default');

        $this->assertInstanceOf(EntityManager::class, $entityManager);
    }
}
