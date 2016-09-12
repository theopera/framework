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

    public function authenticate(UserInterface $user) : bool;

    public function isAuthenticated() : bool;

    public function getAuthenticatedUser() : UserInterface;

}