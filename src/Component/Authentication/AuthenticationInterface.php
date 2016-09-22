<?php
/**
 * The Opera Framework
 * AuthenticationInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


interface AuthenticationInterface
{

    /**
     * Tries to authenticate the provided user
     * using the the verify method of the found user
     *
     * @param UserInterface $user
     * @return bool
     */
    public function authenticate(UserInterface $user) : bool;

    /**
     * When the user is authenticated e.g. higher than the guest level
     *
     * @return bool
     */
    public function isAuthenticated() : bool;

    /**
     * Get the current user
     *
     * When an user is not authenticated a Guest user will be returned
     * with the role 'guest'
     *
     * @return UserInterface
     */
    public function getUser() : UserInterface;

}