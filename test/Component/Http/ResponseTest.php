<?php
/**
 * The Opera Framework
 * ResponseTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   7-9-16
 * @version   1.0
 */

namespace Opera\Component\Http;


use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    public function testBasicHell200ResponseGood()
    {
        $response = new Response('hello', Response::STATUS_OK);

        self::assertEquals('hello', $response->getBody());
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('HTTP/1.1 200 OK', $response->getStatusLine());

        self::assertEquals('text/html', $response->getHeaders()->get('Content-Type')->getValue());
        self::assertEquals('text/html', $response->getContentType());
    }

    public function testGetStatusCodeGood()
    {
        self::assertEquals('OK', Response::getStatusText(Response::STATUS_OK));
        self::assertEquals('Internal Server Error', Response::getStatusText(Response::STATUS_INTERNAL_SERVER_ERROR));
        self::assertEquals('Temporary Redirect', Response::getStatusText(Response::STATUS_TEMPORARY_REDIRECT));
    }

    public function testSetBodyGood()
    {
        $response = new Response('1');
        self::assertEquals('1', $response->getBody());
        $response->setBody('2');
        self::assertEquals('2', $response->getBody());
    }

    public function testRedirectGood()
    {
        $response = Response::redirect('http://example.com/', ['bar' => 'foo']);

        self::assertEquals('http://example.com/?bar=foo', $response->getHeaders()->get('Location')->getValue());
    }

}
