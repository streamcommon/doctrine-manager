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

namespace Streamcommon\Test\Doctrine\Container\Interop\TestAssets\AnnotationEntity;

/**
 * Class TestEntity
 *
 * @package Streamcommon\Test\Doctrine\Container\Interop\TestAssets\AnnotationEntity
 *
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\@Table(name="test")
 */
class TestEntity
{
    /**
     * @Doctrine\ORM\Mapping\Id @Column(type="integer")
     * @Doctrine\ORM\Mapping\GeneratedValue
     */
    protected $id;
}
