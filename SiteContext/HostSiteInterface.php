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
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\SiteInterface;

/**
 * Represents 
 * @author Daniel Leech <daniel@dantleech.com>
 */
class HostSiteInterface extends HostInterface
{
    /**
     * Return the Site this host references
     *
     * @return SiteInterface
     */
    public function getSite();
}


