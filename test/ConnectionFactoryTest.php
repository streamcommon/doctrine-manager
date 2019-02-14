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

use Doctrine\DBAL\Connection;
use Streamcommon\Doctrine\Container\Interop\Factory\ConnectionFactory;

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
