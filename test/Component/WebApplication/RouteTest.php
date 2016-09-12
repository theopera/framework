<?php
/**
 * The Opera Framework
 * RouteTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   28-8-16
 * @version   1.0
 */


namespace Opera\Component\WebApplication;


use Opera\Component\Http\Request;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{

    public function testBasicGood()
    {
        $endpoint = new RouteEndpoint('namespace\\', 'default', 'index', 'get');
        $route = new Route('path', $endpoint);

        self::assertEquals('path', $route->getPath());
        self::assertEquals($endpoint, $route->getEndPoint());
    }
}
