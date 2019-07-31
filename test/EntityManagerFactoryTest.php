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

namespace Streamcommon\Test\Doctrine\Manager;

use Doctrine\ORM\EntityManager;
use Streamcommon\Doctrine\Manager\Factory\EntityManagerFactory;

/**
 * Class EntityManagerFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class EntityManagerFactoryTest extends AbstractFactoryTest
{
    /**
     * Default entity resolver factory creation
     */
    public function testEntityManagerFactoryCreation(): void
    {
        $factory = new EntityManagerFactory();
        $entityManager = $factory($this->getContainer(), 'doctrine.entity_manager.orm_default');

        $this->assertInstanceOf(EntityManager::class, $entityManager);
    }
}
