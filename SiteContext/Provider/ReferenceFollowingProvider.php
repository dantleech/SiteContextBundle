<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Provider;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Daniel Leech <daniel@dantleech.com>
 */
class ReferenceFollowingProvider implements ProviderInterface
{
    private $provider;

    /**
     * @param ManagerRegistry $registry
     * @param string $hostsPath
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $hostsPath;
    }

    /**
     * {@inheritDoc}
     */
    public function provide($hostname)
    {
        $host = $this->provider->provide($hostname);

        if (null === $host) {
            return;
        }

        if ($host instanceof HostReferenceInterface) {
            return $this->provide($host->getName());
        }

        return $host;
    }
}
