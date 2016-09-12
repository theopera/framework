<?php
/**
 * The Opera Framework
 * JsonResponseTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   8-9-16
 * @version   1.0
 */

namespace Opera\Component\Http;


use PHPUnit\Framework\TestCase;

class JsonResponseTest extends TestCase
{

    public function testBasicResponseGood()
    {
        $response = new JsonResponse(['foo'=> 'bar']);

        self::assertEquals('{"foo":"bar"}', $response->getBody());
    }

    public function testOptionsGood()
    {
        $response = new JsonResponse(['foo'=> 'bar'], JSON_PRETTY_PRINT);

        self::assertEquals("{\n    \"foo\": \"bar\"\n}", $response->getBody());
    }


}