<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2014 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Exception;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Cmf\Component\Routing\Event\RouterMatchEvent;
use Symfony\Cmf\Bundle\SiteContextBundle\SiteContext\Exception\HostNotFoundException;

/**
 * Thrown when the a host cannot be found by the host resolver implementations
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class HostNotFoundException extends \RuntimeException
{
}
