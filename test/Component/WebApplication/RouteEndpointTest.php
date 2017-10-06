<?php
/**
 * The Opera Framework
 * RouteEndpointTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   28-8-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use PHPUnit\Framework\TestCase;

class RouteEndpointTest extends TestCase
{

    public function testBasicGood()
    {
        $endpoint = new RouteEndpoint('namespace\\','default','index', 'get');

        self::assertEquals('namespace\\DefaultController', $endpoint->getFullyQualifiedName());
        self::assertEquals('Default', $endpoint->getController());
        self::assertEquals('DefaultController', $endpoint->getController(true));
        self::assertEquals('index', $endpoint->getAction());
        self::assertEquals('get', $endpoint->getMethod());
        self::assertFalse($endpoint->isCallable());
    }
}
