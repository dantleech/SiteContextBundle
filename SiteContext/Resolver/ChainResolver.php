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
use Psr\Log\LoggerInterface;

/**
 * This resolver accepts a collection of resolvers and will try
 * each one in turn before finally failing.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class ChainResolver extends AbstractProviderResolver
{
    /**
     * @var ResolverInterface[]
     */
    private $resolvers;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param HostProvider $provider
     * @param string $queryParameter Request arameter from white to determine
     *                               the host name
     */
    public function __construct(array $resolvers, LoggerInterface $logger = null)
    {
        $this->resolvers = $resolvers;
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(Request $request)
    {
        $tried = array();
        foreach ($this->resolvers as $alias => $resolver) {
            try {
                return $resolver->resolve($request);
            } catch (HostNotFoundException $e) {
                $message = sprintf(
                    'cmf_site_context tried resolver "%s" and it failed: "%s"',
                    $alias, $e->getMessage()
                );
                $tried[] = $alias;

                if (!$this->logger) {
                    continue;
                }

                $this->logger->debug($message);
            }
        }

        throw new HostNotFoundException(sprintf(
            'Chain resolver could not resolve host using resolvers: "%s"',
            implode('", "', $tried)
        ));
    }
}
