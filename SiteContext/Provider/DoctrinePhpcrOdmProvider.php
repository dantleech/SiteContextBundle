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
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ProviderInterface;
use Doctrine\Bundle\PHPCRBundle\ManagerRegistry;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostInterface;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostReferenceInterface;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostSiteInterface;

/**
 * This PHPCR ODM provider expects hosts to be stored using their
 * host names as the document node name. Documents can therefore
 * be retrieved in a simple fetch operation instead of a search.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class DoctrinePhpcrOdmProvider implements ProviderInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var string
     */
    private $hostsPath;

    /**
     * @param ManagerRegistry $registry
     * @param string $hostsPath
     */
    public function __construct(ManagerRegistry $registry, $hostsPath)
    {
        $this->registry = $registry;
        $this->hostsPath = $hostsPath;

        if ('/' !== substr($this->hostsPath, 0, 1)) {
            throw new \InvalidArgumentException(sprintf(
                'Hosts path must be absolute, got "%s"',
                $this->hostsPath
            ));
        }

        if ('/' == substr($this->hostsPath, -1)) {
            throw new \InvalidArgumentException(sprintf(
                'Hosts path must not end with trailing slash, got "%s"',
                $this->hostsPath
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function provide($hostname)
    {
        if (!$hostname) {
            throw new \InvalidArgumentException(sprintf(
                'Host name may not be empty'
            ));
        }
        $manager = $this->registry->getManager();
        $path = sprintf('%s/%s', $this->hostsPath, $hostname);

        $host = $manager->find(null, $path);

        return $this->resolveHost($host);
    }

    /**
     * Recursively resolve the host if it is a
     * host reference document.
     *
     * @return HostSiteInterface
     *
     * @throws RuntimeException
     */
    private function resolveHost(HostInterface $host)
    {
        if ($host instanceof HostSiteInterface) {
            return $host;
        }

        if (!$host instanceof HostReferenceInterface) {
            throw new \RuntimeException(sprintf(
                'Host should be either an instance of HostSiteInterface or HostReferenceInterface. Got "%s"',
                is_object($host) ? get_class($host) : gettype($host)
            ));
        }

        return $host->getHost();
    }
}
