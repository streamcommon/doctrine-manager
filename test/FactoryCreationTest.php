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

use Doctrine\Common\Cache\{CacheProvider, ArrayCache};
use Streamcommon\Doctrine\Container\Interop\Factory\CacheFactory;

/**
 * Class FactoryCreationTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
 */
class FactoryCreationTest extends AbstractFactoryTest
{
    public function testCacheFactory()
    {
        $container = $this->getContainer();

        $factory = new CacheFactory();
        $cache = $factory($container, 'Doctrine\Common\Cache\ArrayCache');

        $this->assertInstanceOf(CacheProvider::class, $cache);
        $this->assertInstanceOf(ArrayCache::class, $cache);
    }
}