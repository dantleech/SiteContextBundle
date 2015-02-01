<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Component\Routing\Event\RouterMatchEvent;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ResolverInterface;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\SiteContextInterface;

/**
 * This listener listens to the pre dynamic match request event from
 * the Symfony CMF RoutingBundle. This event is fired before the router
 * tries to find a route.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class DynamicRouterListener
{
    private $resolver;
    private $siteContext;

    /**
     * @param ResolverInterface $resolver
     */
    public function __construct(ResolverInterface $resolver, SiteContextInterface $siteContext)
    {
        $this->resolver = $resolver;
        $this->siteContext = $siteContext;
    }

    /**
     * {@inheritDoc}
     */
    public function handlePreDynamicMatchRequest(RouterMatchEvent $event)
    {
        $request = $event->getRequest();

        if (null === $request) {
            throw new \RuntimeException(
                'No request object present in the RouterMatchEvent. This probably means '.
                'that the dynamic router was invoked with the deprecated "match" method'
            );
        }

        $host = $this->resolver->resolve($request);
        $this->siteContext->load($host->getSite());
    }
}
