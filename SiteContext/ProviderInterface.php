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
 * Classes implementing this interface should provide implementations
 * of the HostInterface class by hostname.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface ProviderInterface
{
    /**
     * Provide an object implementing HostInterface for
     * the given hostname.
     *
     * The provider must return an instanceof HostSiteInterface.  If the
     * requested host name is an instance of HostReferenceInterface then
     * the reference should be resolved recursively until a HostSiteInterface
     * is found.
     *
     * @param Request $request
     *
     * @return HostSiteInterface
     */
    public function provide($hostname);
}

