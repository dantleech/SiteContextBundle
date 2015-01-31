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

/**
 * Thrown when the site has not been loaded into the site context
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class SiteNotLoadedException extends \RuntimeException
{
}
