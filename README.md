# doctrine-container-interop
[![Latest Stable Version](https://poser.pugx.org/streamcommon/doctrine-container-interop/v/stable)](https://packagist.org/packages/streamcommon/doctrine-container-interop)
[![Total Downloads](https://poser.pugx.org/streamcommon/doctrine-container-interop/downloads)](https://packagist.org/packages/streamcommon/doctrine-container-interop)
[![License](https://poser.pugx.org/streamcommon/doctrine-container-interop/license)](./LICENSE)

This package provide [Doctrine 2](https://github.com/doctrine) factories for [PRS-11](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md) container standard.

# Branches
[![Master][Master branch image]][Master branch] [![Build Status][Master image]][Master] [![Coverage Status][Master coverage image]][Master coverage]

[![Develop][Develop branch image]][Develop branch] [![Build Status][Develop image]][Develop] [![Coverage Status][Develop coverage image]][Develop coverage]

## Installation
Console run:
```console
    composer require streamcommon/factory-container-interop
```
Or add into your `composer.json`:
```json
    "require": {
        "streamcommon/factory-container-interop": "*"
    }
```

## Example
> `Psr\Container\ContainerInterface` container MUST have `config` key

Configure your project config file: 

```php
    'config' => [
        'doctrine' => [
            'configuration' => [
                'orm_default' => [
                    'result_cache' => 'array',
                    'metadata_cache' => 'array',
                    'query_cache' => 'array',
                    'hydration_cache' => 'array',
                    'driver' => 'orm_default',
                ],
            ],
            'connection' => [
                'orm_default' => [
                    'configuration' => 'orm_default',
                    'event_manager' => 'orm_default',
                    'params' => [],
                ],
            ],
            'entity_manager' => [
                'orm_default' => [
                    'connection' => 'orm_default',
                    'configuration' => 'orm_default',
                ],
            ],
            'event_manager' => [
                'orm_default' => [
                    'subscribers' => [],
                ],
            ],
            'entity_resolver' => [
                'orm_default' => [
                    'resolvers' => [],
                ],
            ],
            'driver' => [
                'orm_default' => [
                    'class_name' => 'Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain',
                    'cache' => 'array',
                    'paths' => [],
                    'drivers' => [],
                ],
            ],
            'cache' => [
                'array' => [
                    'class_name' => Doctrine\Common\Cache\ArrayCache,
                    'namespace' => 'Streamcommon\Doctrine\Manager\Interop',
                ]
            ],
        ]
    ],
```

Configure your project dependencies:

```php
    'dependencies' => [
       'factories' => [
            'doctrine.driver.orm_default' => 'Streamcommon\Doctrine\Container\Interop\Factory\DriverFactory',
            'doctrine.event_manager.orm_default' => 'Streamcommon\Doctrine\Container\Interop\Factory\EventManagerFactory',
            'doctrine.configuration.orm_default' => 'Streamcommon\Doctrine\Container\Interop\Factory\ConfigurationFactory',
            'doctrine.connection.orm_default' => 'Streamcommon\Doctrine\Container\Interop\Factory\ConnectionFactory',
            'doctrine.entity_resolver.orm_default' => 'Streamcommon\Doctrine\Container\Interop\Factory\EntityResolverFactory',
            'doctrine.entity_manager.orm_default' => 'Streamcommon\Doctrine\Container\Interop\Factory\EntityManagerFactory',
            'doctrine.cache.array' => 'Streamcommon\Doctrine\Container\Interop\Factory\CacheFactory',
        ],
    ]
```
Use in project:

```php
    $em = $container->get('doctrine.entity_manager.orm_default');
    $connection = $container->get('doctrine.connection.orm_default');
```

[Master branch]: https://github.com/streamcommon/doctrine-container-interop/tree/master
[Master branch image]: https://img.shields.io/badge/branch-master-blue.svg
[Develop branch]: https://github.com/streamcommon/doctrine-container-interop/tree/develop
[Develop branch image]: https://img.shields.io/badge/branch-develop-blue.svg
[Master image]: https://travis-ci.org/streamcommon/doctrine-container-interop.svg?branch=master
[Master]: https://travis-ci.org/streamcommon/doctrine-container-interop
[Master coverage image]: https://coveralls.io/repos/github/streamcommon/doctrine-container-interop/badge.svg?branch=master
[Master coverage]: https://coveralls.io/github/streamcommon/doctrine-container-interop?branch=master
[Develop image]: https://travis-ci.org/streamcommon/doctrine-container-interop.svg?branch=develop
[Develop]: https://travis-ci.org/streamcommon/doctrine-container-interop
[Develop coverage image]: https://coveralls.io/repos/github/streamcommon/doctrine-container-interop/badge.svg?branch=develop
[Develop coverage]: https://coveralls.io/github/streamcommon/doctrine-container-interop?branch=develop