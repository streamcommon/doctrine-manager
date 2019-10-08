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

namespace Streamcommon\Doctrine\Manager\DBAL\Factory;

use Doctrine\DBAL\{Connection as DBALConnection, DriverManager};
use Doctrine\DBAL\Types\Type;
use Psr\Container\ContainerInterface;
use Streamcommon\Doctrine\Manager\AbstractFactory;
use Streamcommon\Doctrine\Manager\Options\Connection as ConnectionOptions;

/**
 * Class Connection
 *
 * @package Streamcommon\Doctrine\Manager\DBAL\Factory
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/configuration.html#getting-a-connection
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/platforms.html#platforms
 * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/types.html#types
 */
class Connection extends AbstractFactory
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param null|array         $options
     * @return DBALConnection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, ?array $options = null): object
    {
        $options = new ConnectionOptions($this->getOptions($container, 'connection'));

        $configuration    = $container->get('doctrine.configuration.' . $options->getConfiguration());
        $eventManager     = $container->get('doctrine.event_manager.' . $options->getEventManager());
        $connectionParams = [
            'driverClass'  => $options->getDriverClassName(),
            'wrapperClass' => $options->getWrapperClassName(),
            'pdo'          => null,
            'dbname'       => $options->getParams()->getDbName(),
            'user'         => $options->getParams()->getUser(),
            'password'     => $options->getParams()->getPassword(),
            'host'         => $options->getParams()->getHost(),
        ];
        if ($options->getPdoClassName() !== null) {
            $connectionParams['pdo'] = $container->get($options->getPdoClassName());
        }
        if ($options->getParams()->getPlatform() !== null) {
            $connectionParams['platform'] = $container->get($options->getParams()->getPlatform());
        }
        if ($options->getParams()->getCharset() !== null) {
            $connectionParams['charset'] = $options->getParams()->getCharset();
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
