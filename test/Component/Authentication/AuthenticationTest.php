<?php
/**
 * The Opera Framework
 * AuthenticationTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


use Opera\Component\Http\Session\Session;
use Opera\Component\Http\Session\SessionInterface;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{

    public function testSimpleAuthenticationGood()
    {
        $user = new User('john', '12345');
        $provider = $this->getMockProvider(new User('john', password_hash('12345', PASSWORD_BCRYPT)));
        $session = $this->getMockSession();

        $auth = new Authentication($provider, $session);

        self::assertTrue($auth->authenticate($user));
        self::assertTrue($auth->isAuthenticated());
        self::assertEquals($auth->getAuthenticatedUser(), $session->get('authenticatedUser'));
        self::assertEquals($user->getUsername(), $auth->getAuthenticatedUser()->getUsername());
        self::assertEquals($user->getRole(), $auth->getAuthenticatedUser()->getRole());
    }

    public function testSimpleAuthenticationBadPassword()
    {
        $user = new User('john', '54321');
        $provider = $this->getMockProvider(new User('john', password_hash('12345', PASSWORD_BCRYPT)));
        $session = $this->getMockSession();

        $auth = new Authentication($provider, $session);

        self::assertFalse($auth->authenticate($user));
        self::assertNull($session->get('authenticatedUser'));
    }


    public function getMockProvider(User $user) : UserProviderInterface
    {
        return new class($user) implements UserProviderInterface{
            private $user;

            public function __construct($user)
            {
                $this->user = $user;
            }

            public function findUser(string $username) : UserInterface
            {
                return $this->user;
            }
        };
    }

    public function getMockSession() : SessionInterface
    {
        return new Session('1a2b3c4d', []);
    }


}
