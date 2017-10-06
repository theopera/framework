<?php
/**
 * The Opera Framework
 * AccessControlListInterface.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 21-9-16
 * @version 1.0
 */
namespace Opera\Component\Authorization;

use Opera\Component\Authentication\UserInterface;

interface AccessControlListInterface
{
    public function hasAccess(UserInterface $user, string $permission) : bool;
}