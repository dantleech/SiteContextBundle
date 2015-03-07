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

use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ProviderInterface;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Exception\HostNotFoundException;

/**
 * The query resolver determines the host from a query
 * parameters. For example ?_site=domain.dom.
 *
 * This is especially useful in development situations.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class QueryResolver extends AbstractProviderResolver
{
    /**
     * @var string
     */
    private $queryParameter;

    /**
     * @param HostProvider $provider
     * @param string $queryParameter Request arameter from white to determine
     *                               the host name
     */
    public function __construct(ProviderInterface $provider, $queryParameter = '_site')
    {
        parent::__construct($provider, $queryParameter);
        $this->queryParameter = $queryParameter;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(Request $request)
    {
        if (false === $request->query->has($this->queryParameter)) {
            $refl = new \ReflectionClass($this);
            throw new HostNotFoundException(sprintf(
                'Host resolver "%s" needs the "%s" query parameter',
                $refl->getShortName(),
                $this->queryParameter
            ));
        }

        return $this->getHost(
            $request->query->get($this->queryParameter)
        );
    }
}
