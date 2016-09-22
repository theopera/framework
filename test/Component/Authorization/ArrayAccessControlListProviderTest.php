<?php
/**
 * The Opera Framework
 * ArrayAccessControlListProviderTest.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 22-9-16
 * @version 1.0
 */

namespace Opera\Component\Authorization;


use PHPUnit\Framework\TestCase;

class ArrayAccessControlListProviderTest extends TestCase
{

    public function testHashRolePermissionGood()
    {
        $provider = new ArrayAccessControlListProvider($this->getPermissionList());

        self::assertTrue($provider->hasRolePermission('user', 'edit_profile'));
        self::assertTrue($provider->hasRolePermission('user', 'delete_profile'));
    }


    public function testHashRolePermissionBad()
    {
        $provider = new ArrayAccessControlListProvider($this->getPermissionList());

        self::assertFalse($provider->hasRolePermission('user', 'view_profile'));
    }



    private function getPermissionList()
    {
        return [
            'user' =>[
                'edit_profile' => true,
                'delete_profile' => true,
            ]
        ];
    }

}
