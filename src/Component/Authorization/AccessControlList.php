<?php
/**
 * The Opera Framework
 * AccessControlList.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 21-9-16
 * @version 1.0
 */

namespace Opera\Component\Authorization;


use Opera\Component\Authentication\UserInterface;

class AccessControlList implements AccessControlListInterface
{
    /**
     * @var AccessControlListProviderInterface
     */
    private $provider;

    /**
     * AccessControlList constructor.
     */
    public function __construct(AccessControlListProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Does the given user have access to the provided permission
     *
     * @param UserInterface $user
     * @param string $permission
     * @return bool
     */
    public function hasAccess(UserInterface $user, string $permission) : bool
    {
        return $this->provider->hasRolePermission($user->getRole(), $permission);
    }
}