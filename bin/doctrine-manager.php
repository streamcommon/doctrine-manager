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

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Input\{ArgvInput, InputArgument};
use Symfony\Component\Console\Command\Command;
use Streamcommon\Doctrine\Manager\ConfigProvider;

if (PHP_SAPI !== 'cli' || PHP_OS !== 'Linux') {
    return false;
}
if (file_exists(__DIR__ . '/../../../autoload.php')) {
    require __DIR__ . '/../../../autoload.php';
} elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    throw new \RuntimeException('File autoload.php not exists');
}

AnnotationRegistry::registerLoader('class_exists');

// Configure container
if (file_exists(__DIR__ . '/../../../../config/config.php')) {
    $config = require __DIR__ . '/../../../../config/config.php';
} else {
    $configProvider = new ConfigProvider();
    $config = $configProvider();
}
$dependencies = $config;
$dependencies['services']['config'] = $config;
// Build container
if (class_exists('Zend\ServiceManager\ServiceManager')) {
    $dependencies = $config['dependencies'];
    $dependencies['services']['config'] = $config;
    $container = new \Zend\ServiceManager\ServiceManager($dependencies);
} elseif (class_exists('Zend\AuraDi\Config\ContainerFactory')) {
    $containerFactory = new \Zend\AuraDi\Config\ContainerFactory();
    $container = $containerFactory(new \Zend\AuraDi\Config\Config($dependencies));
} elseif (class_exists('Zend\Pimple\Config\ContainerFactory')) {
    $containerFactory = new \Zend\Pimple\Config\ContainerFactory();
    $container = $containerFactory(new \Zend\Pimple\Config\Config($dependencies));
} elseif (class_exists('JSoumelidis\SymfonyDI\Config\ContainerFactory')) {
    $containerFactory = new \JSoumelidis\SymfonyDI\Config\ContainerFactory();
    $container = $containerFactory(new \JSoumelidis\SymfonyDI\Config\Config($dependencies));
} else {
    echo 'Cannot find DI container';
    die();
}

$ormName = 'orm_default';
$arguments = new ArgvInput();
if ($arguments->hasParameterOption('--object-manager')) {
    $ormName = $arguments->getParameterOption('--object-manager');
}
$helper = ConsoleRunner::createHelperSet($container->get('doctrine.entity_manager.' . $ormName));

// Create CLI
$cli = ConsoleRunner::createApplication($helper);
$commands = $cli->all('orm');
$commandHash = [];
array_walk($commands, function (Command $command) use (&$commandHash) {
    $hash = spl_object_hash($command);
    if (!in_array($hash, $commandHash)) {
        $command->addArgument(
            '--object-manager',
            InputArgument::OPTIONAL,
            'Doctrine object manager name',
            'orm_default'
        );
        $commandHash[] = $hash;
    }
});
// Run console
try {
    $cli->run();
} catch (\Exception $e) {
    echo $e;
}
