<?php

namespace Symfony\Cmf\Bundle\SiteContextBundle\Unit\SiteContext\Listener;

use Prophecy\PhpUnit\ProphecyTestCase;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Listener\DynamicRouterListener;

class DynamicRouterListenerTest extends ProphecyTestCase
{
    public function setUp()
    {
        $this->resolver = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\ResolverInterface');
        $this->siteContext = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\SiteContextInterface');
        $this->event = $this->prophesize('Symfony\Cmf\Component\Routing\Event\RouterMatchEvent');
        $this->request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->host = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostSiteInterface');
        $this->site = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\SiteInterface');

        $this->dynamicRouterListener = new DynamicRouterListener(
            $this->resolver->reveal(),
            $this->siteContext->reveal()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testEventNoRequest()
    {
        $this->event->getRequest()->willReturn(null);
        $this->dynamicRouterListener->handlePreDynamicMatchRequest($this->event->reveal());
    }

    public function testEvent()
    {
        $this->event->getRequest()->willReturn($this->request->reveal());
        $this->resolver->resolve($this->request->reveal())->willReturn($this->host->reveal());
        $this->host->getSite()->willReturn($this->site->reveal());
        $this->siteContext->load($this->site->reveal())->shouldBeCalled();
        $this->dynamicRouterListener->handlePreDynamicMatchRequest($this->event->reveal());
    }
}
