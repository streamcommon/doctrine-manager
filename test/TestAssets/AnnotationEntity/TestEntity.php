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

namespace Streamcommon\Test\Doctrine\Manager\TestAssets\AnnotationEntity;

/**
 * Class TestEntity
 *
 * @package Streamcommon\Test\Doctrine\Manager\TestAssets\AnnotationEntity
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
