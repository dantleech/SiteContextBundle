<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver;

use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ResolverInterface;
use Symfony\Component\HttpFoundation\Request;

class QueryResolver implements ResolverInterface
{
    private $queryParameter;

    public function __construct(HostProvider $provider, $queryParameter = '_site')
    {
        parent::__construct($provider, $queryParameter);
        $this->queryParameter = $queryParameter;
    }

    public function resolve(Request $request)
    {
        if (false === $request->query->has($this->queryParameter)) {
            throw new Exception\HostNotFoundException(sprintf(
                'Host resolver "%s" needs the "%s" query parameter',
                $refl->getShortName(),
                $this->queryParameter,
            ));
        }

        return $this->getHost(
            $request->query->get($this->queryParameter)
        );
    }
}
