<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Host;

use Symfony\Component\HttpFoundation\Request;

class DummyHostSite implements HostSiteInterface
{
    private $hostName;

    public function __construct($hostName)
    {
        $this->hostName = $hostName;
    }

    public function getName()
    {
        return $this->hostName;
    }

    public function getSite()
    {
        throw new \BadMethodCallException('Dummy host does not return Site');
    }
}
