<?php
/**
 * The Opera Framework
 * Cookie.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   27-8-16
 * @version   1.0
 */


namespace Opera\Component\Authentication;


use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testBasicUserGood()
    {
        $user = new User('john', 'doe');

        self::assertEquals('john', $user->getUsername());
        self::assertEquals('doe', $user->getPassword());
        self::assertEquals('user', $user->getRole());
    }

    public function testRoleGood()
    {
        $user = new User('john', 'doe', 'admin');

        self::assertEquals('admin', $user->getRole());
    }

}