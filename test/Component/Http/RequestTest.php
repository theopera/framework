<?php
/**
 * The Opera Framework
 * RequestTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   27-8-16
 * @version   1.0
 */


namespace Opera\Component\Http;


use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    public function testBasicGetRequestGood()
    {
        $request = new Request(Request::METHOD_GET);

        self::assertEquals('GET', $request->getMethod());
        self::assertEquals('/', $request->getUri());
        self::assertEquals('/', $request->getPathInfo());
    }

    public function testBasicPostRequestGood()
    {
        $request = new Request(Request::METHOD_POST, '/', null, [], ['foo' => 'bar']);

        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(['foo' => 'bar'], $request->getPost()->export());
    }

    public function testIsGetGood()
    {
        $request = new Request(Request::METHOD_GET);

        self::assertTrue($request->isGet());
        self::assertFalse($request->isDelete());
        self::assertFalse($request->isHead());
        self::assertFalse($request->isOptions());
        self::assertFalse($request->isPatch());
        self::assertFalse($request->isPost());
        self::assertFalse($request->isUpdate());
    }

    public function testIsPostGood()
    {
        $request = new Request(Request::METHOD_POST);

        self::assertTrue($request->isPost());
        self::assertFalse($request->isDelete());
        self::assertFalse($request->isHead());
        self::assertFalse($request->isOptions());
        self::assertFalse($request->isPatch());
        self::assertFalse($request->isGet());
        self::assertFalse($request->isUpdate());
    }

    public function testIsDeleteGood()
    {
        $request = new Request(Request::METHOD_DELETE);

        self::assertTrue($request->isDelete());
        self::assertFalse($request->isPost());
        self::assertFalse($request->isHead());
        self::assertFalse($request->isOptions());
        self::assertFalse($request->isPatch());
        self::assertFalse($request->isGet());
        self::assertFalse($request->isUpdate());
    }

    public function testIsHeadGood()
    {
        $request = new Request(Request::METHOD_HEAD);

        self::assertTrue($request->isHead());
        self::assertFalse($request->isPost());
        self::assertFalse($request->isDelete());
        self::assertFalse($request->isOptions());
        self::assertFalse($request->isPatch());
        self::assertFalse($request->isGet());
        self::assertFalse($request->isUpdate());
    }

    public function testIsOptionGood()
    {
        $request = new Request(Request::METHOD_OPTIONS);

        self::assertTrue($request->isOptions());
        self::assertFalse($request->isPost());
        self::assertFalse($request->isDelete());
        self::assertFalse($request->isHead());
        self::assertFalse($request->isPatch());
        self::assertFalse($request->isGet());
        self::assertFalse($request->isUpdate());
    }

    public function testIsPatchGood()
    {
        $request = new Request(Request::METHOD_PATCH);

        self::assertTrue($request->isPatch());
        self::assertFalse($request->isPost());
        self::assertFalse($request->isDelete());
        self::assertFalse($request->isHead());
        self::assertFalse($request->isOptions());
        self::assertFalse($request->isGet());
        self::assertFalse($request->isUpdate());
    }

    public function testIsUpdateGood()
    {
        $request = new Request(Request::METHOD_UPDATE);

        self::assertTrue($request->isUpdate());
        self::assertFalse($request->isPost());
        self::assertFalse($request->isDelete());
        self::assertFalse($request->isHead());
        self::assertFalse($request->isOptions());
        self::assertFalse($request->isGet());
        self::assertFalse($request->isPatch());
    }

    public function testSetMethodGood()
    {
        $request = new Request(Request::METHOD_GET);
        self::assertEquals('GET', $request->getMethod());
        $request->setMethod(Request::METHOD_POST);
        self::assertEquals('POST', $request->getMethod());
    }

    public function testSetUriGood()
    {
        $request = new Request(Request::METHOD_GET);
        self::assertEquals('/', $request->getUri());
        $request->setUri('/hello');
        self::assertEquals('/hello', $request->getUri());
    }

    /**
     * This uri assignment does not start with a slash, which is required
     */
    public function testSetUriBad()
    {
        $request = new Request(Request::METHOD_GET, '');
        self::assertEquals('/', $request->getUri());
        $request->setUri('hello');
        self::assertEquals('/hello', $request->getUri());
    }

    public function testGetQueryEmptyGood()
    {
        $request = new Request(Request::METHOD_GET);
        self::assertEquals([], $request->getQuery()->export());
    }

    public function testGetQueryGood()
    {
        $request = new Request(Request::METHOD_GET, '/', null, ['foo' => 'bar']);
        self::assertEquals('bar', $request->getQuery()->get('foo'));
    }

    public function testGetPostEmptyGood()
    {
        $request = new Request(Request::METHOD_GET, '/', null, [], []);
        self::assertEquals([], $request->getPost()->export());
    }

    public function testGetPostGood()
    {
        $request = new Request(Request::METHOD_GET, '/', null, [], ['foo' => 'bar']);
        self::assertEquals('bar', $request->getPost()->get('foo'));
    }

    public function testCreateFromStringGood()
    {
        $request = Request::createFromString($this->getRequestString('basic-request'));

        self::assertEquals('GET', $request->getMethod());
        self::assertEquals('example.com', $request->getHost());
        self::assertEquals('bar', $request->getQuery()->get('foo'));
    }

    public function testCreateFromStringQueryEmptyBad()
    {
        $request = Request::createFromString($this->getRequestString('basic-request-empty-query'));

        self::assertEquals([], $request->getQuery()->export());
    }

    public function testToStringGood()
    {
        $headers = new Headers();
        $headers->add(new Header('Host', 'example.com'));
        $request = new Request(Request::METHOD_GET, '/foo/bar?foo=bar', $headers);

        self::assertEquals($this->getRequestString('basic-request'), (string) $request);
    }

    private function getRequestString(string $name) : string
    {
        return file_get_contents(__DIR__ . '/resource/' . $name . '.txt');
    }

}