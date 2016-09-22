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
     * The Bcrypt hash of the password
     * @var string
     */
    private $passwordHash;

    /**
     * @var string
     */
    private $role;

    /**
     * User constructor.
     *
     * @param string $username
     */
    public function __construct(string $username, string $role = 'user')
    {
        $this->username = $username;
        $this->role = $role;
    }


    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set a password hash generated with password_hash('pass', PASSWORD_BCRYPT)
     *
     * @param string $passwordHash
     *
     * @return self
     */
    public function setPasswordHash(string $passwordHash) : self
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * Set the role of this user
     *
     * @param string $role
     *
     * @return self
     */
    public function setRole(string $role) : self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function verify(UserInterface $user) : bool
    {
        if ($user instanceof User) {
            if (!empty($this->passwordHash) && !empty($user->password)) {
                return password_verify($user->password, $this->passwordHash);
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getRole() : string
    {
        return $this->role;
    }


}