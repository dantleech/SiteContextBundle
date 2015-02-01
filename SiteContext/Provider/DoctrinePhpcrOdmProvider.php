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

        return $manager->find(null, $path);
    }
}
