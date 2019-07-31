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

use Doctrine\DBAL\Connection;
use Streamcommon\Doctrine\Manager\Factory\ConnectionFactory;

/**
 * Class ConnectionFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class ConnectionFactoryTest extends AbstractFactoryTest
{
    /**
     * Default connection factory creation
     */
    public function testConnectionFactoryCreation(): void
    {
        $factory = new ConnectionFactory();
        $connection = $factory($this->getContainer(), 'doctrine.connection.orm_default');

        $this->assertInstanceOf(Connection::class, $connection);
    }
}
