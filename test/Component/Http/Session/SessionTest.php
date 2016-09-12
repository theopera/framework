<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 27-8-16
 * Time: 21:42
 */

namespace Opera\Component\Http\Session;


use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{

    public function testIdGood()
    {
        $session = new Session('ab1234');

        self::assertEquals('ab1234', $session->getId());
    }
}