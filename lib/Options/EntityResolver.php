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

namespace Streamcommon\Doctrine\Manager\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Class EntityResolver
 *
 * @package Streamcommon\Doctrine\Manager\Options
 */
class EntityResolver extends AbstractOptions
{
    /** @var array<mixed> */
    protected $resolvers = [];

    /**
     * Get resolvers
     *
     * @return array<mixed>
     */
    public function getResolvers(): array
    {
        return $this->resolvers;
    }

    /**
     * Set resolvers
     *
     * @param array<mixed> $resolvers
     * @return EntityResolver
     */
    public function setResolvers(array $resolvers): EntityResolver
    {
        $this->resolvers = $resolvers;
        return $this;
    }
}
