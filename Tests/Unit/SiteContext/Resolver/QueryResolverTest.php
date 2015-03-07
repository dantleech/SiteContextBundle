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
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\QueryResolver;
use Symfony\Component\HttpFoundation\Request;

class QueryResolverTest extends ProphecyTestCase
{
    public function setUp()
    {
        $this->provider = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ProviderInterface');
        $this->request = new Request();
        $this->host = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostSiteInterface');
    }

    /**
     * @expectedException Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Exception\HostNotFoundException
     */
    public function testResolverNoParameter()
    {
        $parameter = '_foo';

        $resolver = $this->createResolver($parameter);
        $host = $resolver->resolve($this->request);
    }

    public function testResolver()
    {
        $param = '_site';
        $host = 'foobar.com';
        $this->request->query->set($param, $host);
        $this->provider->provide($host)->willReturn($this->host->reveal());

        $host = $this->createResolver($param)->resolve($this->request);

        $this->assertSame(
            $this->host->reveal(),
            $host
        );
    }

    private function createResolver($parameter)
    {
        return new QueryResolver(
            $this->provider->reveal(),
            $parameter
        );
    }
}


