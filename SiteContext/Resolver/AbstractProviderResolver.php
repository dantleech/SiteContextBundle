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

abstract class AbstractProviderResolver implements ResolverInterface
{
    private $provider;

    public function __construct(HostProvider $provider, $defaultHostname)
    {
        $this->provider = $provider;
    }

    protected function getHost($hostname)
    {
        $host = $this->provider->provide($hostname);

        if (null === $host) {
            $refl = new \ReflectionClass($this);
            throw new Exception\HostNotFoundException(sprintf(
                'Host resolver "%s" could not resolve host "%s"',
                $refl->getShortName(),
                $hostname,
            ));
        }

        return $host;
    }
}

