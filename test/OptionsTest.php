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

use PHPUnit\Framework\TestCase;
use Streamcommon\Doctrine\Container\Interop\Options\Cache;

/**
 * Class OptionsTest
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop
 */
class OptionsTest extends TestCase
{
    /**
     * Test cache options
     */
    public function testCacheOption(): void
    {
        $config = [
            'class_name' => 'classname',
            'namespace' => 'classname',
            'instance' => 'classname',
            'path' => '/tmp'
        ];
        $options = new Cache($config);

        $this->assertEquals($config, $options->toArray());
    }
}