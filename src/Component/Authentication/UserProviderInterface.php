<?php
/**
 * The Opera Framework
 * UserProviderInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


interface UserProviderInterface
{

    /**
     * @param string $username
     *
     *
     * @return UserInterface
     */
    public function findUser(string $username) : UserInterface;
}