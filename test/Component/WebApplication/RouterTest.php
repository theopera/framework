<?php
/**
 * The Opera Framework
 * RouterTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   28-8-16
 * @version   1.0
 */


namespace Opera\Component\WebApplication;


use Opera\Component\Http\RequestInterface;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testSimpleResolveGood()
    {
        $context = $this->getMockBuilder(Context::class)->getMock();
        $context->method('getControllerNamespace')->willReturn('Context\\');
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $request->method('getPathInfo')->willReturn('/default/welcome');
        $collection = $this->getMockBuilder(RouteCollection::class)->setConstructorArgs(['Collection\\'])->getMock();


        $router = new Router($context);
        $router->addRouteCollection($collection);
        $route = $router->resolve($request);
        $endpoint = $route->getEndPoint();

        self::assertEquals('/default/welcome', $route->getPath());
        self::assertEquals('Context\\DefaultController', $endpoint->getFullyQualifiedName());
        self::assertEquals('welcome', $endpoint->getAction());

    }

}