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

namespace Streamcommon\Test\Doctrine\Container\Interop;

use Doctrine\ORM\EntityManager;
use Streamcommon\Doctrine\Container\Interop\Factory\EntityManagerFactory;

/**
 * Class EntityManagerFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
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
