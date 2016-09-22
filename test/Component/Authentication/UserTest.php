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
        $password = '32%Dft4fYd44r45^';
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $mainUser = new User('john', 'user');
        $mainUser->setPasswordHash($passwordHash);

        $user = new User('john', 'user');
        $user->setPassword($password);

        self::assertEquals('john', $mainUser->getUsername());
        self::assertEquals('user', $mainUser->getRole());

        // Correct user & pass
        self::assertTrue($mainUser->verify($user));
    }

    public function testBasicUserWrongPasswordBad()
    {
        $password = '32%Dft4fYd44r45^';
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $mainUser = new User('john', 'user');
        $mainUser->setPasswordHash($passwordHash);

        $user = new User('john', 'user');
        $user->setPassword('reTY54tq4t5yqw5');

        // Incorrect pass
        self::assertFalse($mainUser->verify($user));
    }

    public function testBasicUserWrongUsernameBad()
    {
        $password = '32%Dft4fYd44r45^';
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $mainUser = new User('john', 'user');
        $mainUser->setPasswordHash($passwordHash);

        $user = new User('peter', 'user');
        $user->setPassword('reTY54tq4t5yqw5');

        // Incorrect username
        self::assertFalse($mainUser->verify($user));
    }

    public function testRoleGood()
    {
        $user = new User('john' , 'admin');

        self::assertEquals('admin', $user->getRole());
    }

}