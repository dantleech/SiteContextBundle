<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostInterface;

/**
 * Represents 
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface HostReferenceInterface extends HostInterface
{
    /**
     * Return the referenced host
     *
     * @return HostInterface
     */
    public function getHost();
}


