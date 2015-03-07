<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
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
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Host\DummyHostSite;

/**
 * This PHPCR ODM provider expects hosts to be stored using their
 * host names as the document node name. Documents can therefore
 * be retrieved in a simple fetch operation instead of a search.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class TestProvider implements ProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function provide($hostname)
    {
        return new DummyHostSite($hostname);
    }
}
