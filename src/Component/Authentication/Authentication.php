<?php
/**
 * The Opera Framework
 * Authentication.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


use Opera\Component\Http\Session\SessionInterface;

class Authentication implements AuthenticationInterface
{

    /**
     * @var UserProviderInterface
     */
    protected $provider;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Authentication constructor.
     *
     * @param UserProviderInterface $provider
     * @param SessionInterface      $session
     */
    public function __construct(UserProviderInterface $provider, SessionInterface $session)
    {
        $this->provider = $provider;
        $this->session = $session;
    }

    public function authenticate(UserInterface $user) : bool
    {
        $foundUser = $this->provider->findUser($user->getUsername());

        if ($foundUser->verify($user)) {
            $this->session->add('authenticatedUser', $foundUser);
            return true;
        }

        return false;
    }

    /**
     * Returns the if the current user in this session is authenticated
     *
     * @return bool
     */
    public function isAuthenticated() : bool
    {
        return $this->session->exists('authenticatedUser');
    }

    public function getUser() : UserInterface
    {
        $user = $this->session->get('authenticatedUser');

        if ($user === null) {
            return new User('Guest', 'guest');
        }

        return $user;
    }


}