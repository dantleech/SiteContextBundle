<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\Unit\SiteContext\Resolver;

use Prophecy\PhpUnit\ProphecyTestCase;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Provider\DoctrinePhpcrOdmProvider;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\DefaultResolver;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\ChainResolver;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Exception\HostNotFoundException;
use Prophecy\Argument;

class ChainResolverTest extends ProphecyTestCase
{
    public function setUp()
    {
        $this->resolver1 = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ResolverInterface');
        $this->resolver2 = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ResolverInterface');
        $this->request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->logger = $this->prophesize('Psr\Log\LoggerInterface');
        $this->hostSite = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostSiteInterface');
    }

    /**
     * @expectedException Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Exception\HostNotFoundException
     * @expectedExceptionMessage Chain resolver could not resolve host using resolvers: "one", "two"
     */
    public function testResolverNoResolution()
    {
        $chainResolver = new ChainResolver(array(
            'one' => $this->resolver1->reveal(),
            'two' => $this->resolver2->reveal()
        ), $this->logger->reveal());

        $this->resolver1->resolve($this->request->reveal())->willThrow(new HostNotFoundException('Host not found'));
        $this->resolver2->resolve($this->request->reveal())->willThrow(new HostNotFoundException('Host not found'));

        $this->logger->debug(Argument::any())->shouldBeCalledTimes(2);

        $chainResolver->resolve($this->request->reveal());
    }

    public function testResolverResolution()
    {
        $chainResolver = new ChainResolver(array(
            'one' => $this->resolver1->reveal(),
            'two' => $this->resolver2->reveal()
        ), $this->logger->reveal());

        $this->resolver1->resolve($this->request->reveal())->willThrow(new HostNotFoundException('Host not found'));
        $this->resolver2->resolve($this->request->reveal())->willReturn($this->hostSite->reveal());

        $this->logger->debug(Argument::any())->shouldBeCalledTimes(1);

        $result = $chainResolver->resolve($this->request->reveal());
        $this->assertSame($this->hostSite->reveal(), $result);
    }
}
