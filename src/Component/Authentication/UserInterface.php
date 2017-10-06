<?php
/**
 * The Opera Framework
 * UserInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


interface UserInterface
{

    /**
     * The username of the user
     *
     * @return string
     */
    public function getUsername() : string;

    /**
     * Verifies that the given user is equal to this object
     *
     * @return string
     */
    public function verify(UserInterface $user) : bool;

    /**
     * the role of the user e.g. admin, moderator
     *
     * @return string
     */
    public function getRole() : string;
}