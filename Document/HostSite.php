<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\RoutingAutoBundle\Document;

class Host implements HostInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ContextInterface
     */
    private $target;

    public function getName()
    {
        return $this->name;
    }

    public function getTarget()
    {
        return $this->target;
    }
}
