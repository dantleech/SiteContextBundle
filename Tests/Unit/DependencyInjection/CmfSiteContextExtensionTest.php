<?php

namespace Symfony\Cmf\Bundle\Unit\DependencyInjection;

use Symfony\Cmf\Bundle\SiteContextBundle\DependencyInjection\CmfSiteContextExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Cmf\Bundle\SiteContextBundle\DependencyInjection\Compiler\SiteContextPass;

class CmfSiteContextExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $container;
    private $extension;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->container->addCompilerPass(new SiteContextPass());
        $this->extension = new CmfSiteContextExtension();
    }

    public function provideLoadResolvers()
    {
        return array(
            array(
                array(
                    'enabled_provider' => 'dummy',
                    'enabled_resolvers' => array('default', 'host'),
                ),
                array(
                    'Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\DefaultResolver',
                    'Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\HostResolver',
                ),
            ),
            array(
                array(
                    'enabled_provider' => 'dummy',
                    'enabled_resolvers' => array('default'),
                ),
                array(
                    'Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\DefaultResolver',
                ),
            ),
            array(
                array(
                    'enabled_provider' => 'dummy',
                    'enabled_resolvers' => array(),
                ),
                array(
                ),
                array('Symfony\Component\DependencyInjection\Exception\RuntimeException', 'You must enable at least one')
            ),
        );
    }

    /**
     * @dataProvider provideLoadResolvers
     */
    public function testLoadResolvers($config, $expectedResolvers, $expectedException = array())
    {
        if (!empty($expectedException)) {
            $this->setExpectedException($expectedException[0], $expectedException[1]);
        }

        $configs = array($config);
        $this->extension->load($configs, $this->container);
        $this->container->compile();
        $resolverDefinition = $this->container->getDefinition('cmf_site_context.resolver');

        if (count($expectedResolvers) == 1) {
            $expectedResolver = reset($expectedResolvers);
            $this->assertEquals($expectedResolver, $resolverDefinition->getClass());
            return;
        }

        $this->assertEquals(
            'Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Resolver\ChainResolver',
            $resolverDefinition->getClass()
        );

        $chainedResolverDefs = $resolverDefinition->getArgument(0);

        foreach ($chainedResolverDefs as $chainedResolverDef) {
            $this->assertContains($chainedResolverDef->getClass(), $expectedResolvers);
        }
    }
}
