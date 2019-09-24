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

use Doctrine\Common\Cache\{CacheProvider, ArrayCache};
use Streamcommon\Doctrine\Manager\Exception\RuntimeException;
use Streamcommon\Doctrine\Manager\Factory\CacheFactory;

/**
 * Class CacheFactoryTest
 *
 * @package Streamcommon\Test\Doctrine\Manager
 */
class CacheFactoryTest extends AbstractFactoryTest
{

    /**
     * Default cache factory creation
     *
     * @return void
     */
    public function testCacheFactoryCreation(): void
    {
        $factory = new CacheFactory();
        $cache = $factory($this->getContainer(), 'doctrine.cache.array');

        $this->assertInstanceOf(CacheProvider::class, $cache);
        $this->assertInstanceOf(ArrayCache::class, $cache);
    }

    /**
     * Test null class name exception
     *
     * @return void
     */
    public function testCacheNullClassNameException(): void
    {
        $this->config['doctrine']['cache']['array']['class_name'] = null;

        $factory = new CacheFactory();
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.cache.array');
    }

    /**
     * Test cache container exists
     *
     * @return void
     */
    public function testCacheContainer(): void
    {
        $this->config['doctrine']['cache']['array']['class_name'] = 'TestAssets\ArrayCache';

        $factory = new CacheFactory();
        $cache = $factory($this->getContainer(), 'doctrine.cache.array');

        $this->assertInstanceOf(CacheProvider::class, $cache);
        $this->assertInstanceOf(ArrayCache::class, $cache);
    }

    /**
     * Test not exists cache class
     *
     * @return void
     */
    public function testCacheClassNotExist(): void
    {
        $this->config['doctrine']['cache']['array']['class_name'] = 'TestAssets\NotExistClass';

        $factory = new CacheFactory();
        $this->expectException(RuntimeException::class);
        $factory($this->getContainer(), 'doctrine.cache.array');
    }
}
