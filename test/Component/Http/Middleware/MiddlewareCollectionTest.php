<?php
/**
 * The Opera Framework
 * MiddlewareCollectionTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   10-9-16
 * @version   1.0
 */

namespace Opera\Component\Http\Middleware;


use Opera\Component\Http\RequestInterface;
use PHPUnit\Framework\TestCase;

class MiddlewareCollectionTest extends TestCase
{

    public function testBasicGood()
    {

        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $collection = new MiddlewareCollection($request);
    }
}