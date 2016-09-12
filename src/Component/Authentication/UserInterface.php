<?php
/**
 * The Opera Framework
 * UserInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
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
     * The password of the user
     *
     * @return string
     */
    public function getPassword() : string;

    /**
     * the role of the user e.g. admin, moderator
     *
     * @return string
     */
    public function getRole() : string;
}