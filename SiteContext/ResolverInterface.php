<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext;

use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Resolve the given request to an object implementing
 * HostInterface
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
interface ResolverInterface
{
    /**
     * @param Request $request
     *
     * @return HostInterface
     */
    public function resolve(Request $request);
}
