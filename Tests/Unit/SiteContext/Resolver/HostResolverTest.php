<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\Unit\SiteContext\Listener;

use Prophecy\PhpUnit\ProphecyTestCase;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Provider\DoctrinePhpcrOdmProvider;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\HostResolver;

class HostResolverTest extends ProphecyTestCase
{
    public function setUp()
    {
        $this->provider = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ProviderInterface');
        $this->request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->host = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostSiteInterface');
        $this->resolver = new HostResolver(
            $this->provider->reveal()
        );
    }

    public function testResolver()
    {
        $hostname = 'domain.dom';
        $this->request->getHost()->willReturn($hostname);
        $this->provider->provide($hostname)->willReturn($this->host->reveal());

        $host = $this->resolver->resolve($this->request->reveal());
        $this->assertSame(
            $this->host->reveal(),
            $host
        );
    }
}
