<?php
/**
 * The Opera Framework
 * User.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Authentication;


class User implements UserInterface
{

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $role;

    /**
     * User constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $role
     */
    public function __construct(string $username, string $password, string $role = 'user')
    {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }


    public function getUsername() : string
    {
        return $this->username;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getRole() : string
    {
        return $this->role;
    }


}