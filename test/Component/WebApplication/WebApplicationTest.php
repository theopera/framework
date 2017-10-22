<?php
/**
 * The Opera Framework
 * WebApplication.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   10-9-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use DOMDocument;
use DOMXPath;
use Opera\Component\Http\RequestInterface;
use PHPUnit\Framework\TestCase;

class WebApplicationTest extends TestCase
{

    public function testBasicGood()
    {
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $context = $this->getMockBuilder(Context::class)->getMock();

        $app = new WebApplication($context);
        $response = $app->run($request);

        // TODO: Make some tests

    }

}