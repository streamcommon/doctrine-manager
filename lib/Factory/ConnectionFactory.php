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

namespace Streamcommon\Doctrine\Container\Interop\Factory;

use Doctrine\DBAL\{Connection, DriverManager};
use Doctrine\DBAL\Types\Type;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Container\Interop\Options\Connection as ConnectionOptions;

/**
 * Class ConnectionFactory
 *
 * @package Streamcommon\Doctrine\Container\Interop\Factory
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/configuration.html#getting-a-connection
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/platforms.html#platforms
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/types.html#types
 */
class ConnectionFactory extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new ConnectionOptions($this->getOptions($container, 'connection'));

        $configuration = $container->get('doctrine.configuration.' . $options->getConfiguration());
        $eventManager = $container->get('doctrine.event_manager.' . $options->getEventManager());
        $connectionParams = [
            'driverClass' => $options->getDriverClassName(),
            'wrapperClass' => $options->getWrapperClassName(),
            'pdo' => null
        ];
        if ($options->getPdoClassName() !== null) {
            $connectionParams['pdo'] = $container->get($options->getPdoClassName());
        }
        if ($options->getParams()->getPlatform() !== null) {
            $connectionParams['platform'] = $container->get($options->getParams()->getPlatform());
        }
        $connection = DriverManager::getConnection($connectionParams, $configuration, $eventManager);
        foreach ($options->getTypeMapping() as $dbType => $doctrineType) {
            $connection->getDatabasePlatform()->registerDoctrineTypeMapping($dbType, $doctrineType);
        }
        foreach ($options->getCommentedTypes() as $type) {
            $connection->getDatabasePlatform()->markDoctrineTypeCommented(Type::getType($type));
        }
        return $connection;
    }
}
