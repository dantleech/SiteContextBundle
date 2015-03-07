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

class DoctrinePhpcrOdmProviderTest extends ProphecyTestCase
{
    public function setUp()
    {
        $this->managerRegistry = $this->prophesize('Doctrine\Bundle\PHPCRBundle\ManagerRegistry');
        $this->manager = $this->prophesize('Doctrine\ODM\PHPCR\DocumentManager');
        $this->siteHost = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostSiteInterface');
        $this->referenceHost = $this->prophesize('Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\HostReferenceInterface');
    }

    public function provideProvide()
    {
        return array(
            array('host.dom', '/path/to', null),
            array('', '/path/to', 'Host name may not be empty'),
            array('host.dom', 'path/to', 'Hosts path must be absolute'),
            array('host.dom', '/path/to/', 'Hosts path must not end with trailing slash'),
        );
    }

    /**
     * @dataProvider provideProvide
     */
    public function testProvide($hostName, $path, $exception = null)
    {
        if ($exception) {
            $this->setExpectedException('InvalidArgumentException', $exception);
        }

        $provider = $this->createProvider($path);
        $this->managerRegistry->getManager()->willReturn($this->manager);
        $this->manager->find(null, $path . '/' . $hostName)->willReturn($this->siteHost->reveal());

        $host = $provider->provide($hostName);
        $this->assertSame($this->siteHost->reveal(), $host);
    }

    public function testProvideReferenced()
    {
        $path = '/path/to';
        $hostName = 'foobar.dom';
        $provider = $this->createProvider($path);
        $this->managerRegistry->getManager()->willReturn($this->manager);
        $this->manager->find(null, $path . '/' . $hostName)->willReturn($this->referenceHost->reveal());
        $this->referenceHost->getHost()->willReturn($this->siteHost);

        $host = $provider->provide($hostName);
        $this->assertSame($this->siteHost->reveal(), $host);
    }

    private function createProvider($path)
    {
        return new DoctrinePhpcrOdmProvider(
            $this->managerRegistry->reveal(),
            $path
        );
    }
}
