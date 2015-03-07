<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\AbstractProviderResolver;

class HostResolver extends AbstractProviderResolver
{
    /**
     * {@inheritDoc}
     */
    public function resolve(Request $request)
    {
        return $this->getHost($request->getHost());
    }
}
