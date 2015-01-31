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
class DoctrinePhpcrOdmProvider implements ProviderInterface
{
    private $registry;
    private $hostsPath;

    /**
     * @param ManagerRegistry $registry
     * @param string $hostsPath
     */
    public function __construct(ManagerRegistry $registry, $hostsPath)
    {
        $this->registry = $registry;
        $this->hostsPath = $hostsPath;
    }

    /**
     * {@inheritDoc}
     */
    public function provide($hostname)
    {
        $manager = $this->registry->getManager();
        $path = sprintf('%s/%s', $this->hostsPath, $hostname);

        return $manager->find(null, $path);
    }
}
