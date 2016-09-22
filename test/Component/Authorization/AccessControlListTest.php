<?php
/**
 * The Opera Framework
 * AccessControlListTest.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 22-9-16
 * @version 1.0
 */

namespace Opera\Component\Authorization;


use Opera\Component\Authentication\User;
use PHPUnit\Framework\TestCase;

class AccessControlListTest extends TestCase
{

    public function testHasNoAccessBad()
    {
        $provider = $this->getMockBuilder(AccessControlListProviderInterface::class)->getMock();
        $user = new User('Guest', 'guest');
        $acl = new AccessControlList($provider);

        self::assertFalse($acl->hasAccess($user, 'edit_user'));
    }

    public function testHasAccessGood()
    {
        $provider = $this->getMockBuilder(AccessControlListProviderInterface::class)->getMock();
        $provider->method('hasRolePermission')->willReturn(true);
        $user = new User('Guest', 'guest');
        $acl = new AccessControlList($provider);

        self::assertTrue($acl->hasAccess($user, 'edit_user'));
    }
}
