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
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\DefaultResolver;

class DefaultResolverTest extends ProphecyTestCase
{
    public function setUp()
    {
        $this->provider = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ProviderInterface');
        $this->request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->host = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostSiteInterface');
    }

    public function testResolver()
    {
        $host = 'domain.dom';

        $resolver = $this->createResolver($host);

        $this->provider->provide($host)->willReturn($this->host->reveal());

        $host = $resolver->resolve($this->request->reveal());
        $this->assertSame(
            $this->host->reveal(),
            $host
        );
    }

    private function createResolver($host)
    {
        return new DefaultResolver(
            $this->provider->reveal(),
            $host
        );
    }
}

