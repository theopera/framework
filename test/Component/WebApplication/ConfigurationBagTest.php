<?php
/**
 * The Opera Framework
 * ConfigurationBagTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   28-8-16
 * @version   1.0
 */


namespace Opera\Component\WebApplication;


use PHPUnit\Framework\TestCase;

class ConfigurationBagTest extends TestCase
{

    public function testGetGood()
    {
        $config = new Configuration($this->getSampleConfiguration());

        self::assertEquals('development', $config->getSection('general')->get('environment'));
        self::assertEquals('The Opera Sample Site', $config->getSection('general')->get('name'));
        self::assertEquals('default', $config->getSection('general')->get('not-existing', 'default'));
    }

    public function testGetBoolGood()
    {
        $config = new Configuration($this->getSampleConfiguration());

        self::assertTrue($config->getSection('general')->getBool('use-database'));
        self::assertFalse($config->getSection('general')->getBool('use-cache'));
        self::assertTrue($config->getSection('general')->getBool('live'));
        self::assertFalse($config->getSection('general')->getBool('assets'));
        self::assertTrue($config->getSection('general')->getBool('webshop'));
        self::assertFalse($config->getSection('general')->getBool('cart'));
        self::assertTrue($config->getSection('general')->getBool('default-true', true));
        self::assertFalse($config->getSection('general')->getBool('default-false', false));
        self::assertTrue($config->getSection('non-existing-section')->getBool('default-true', true));
        self::assertFalse($config->getSection('non-existing-section')->getBool('default-false', false));
    }


    private function getSampleConfiguration() : array
    {
        return [
            'general' => [
                'environment' => 'development',
                'name' => 'The Opera Sample Site',
                'use-database' => true,
                'use-cache' => false,
                'live' => 'true',
                'assets' => 'false',
                'webshop' => 1,
                'cart' => 0,
                'rate-limiting' => 120,
                'users' => [
                    [
                        'username' => 'admin',
                        'password' => '1234',
                    ],
                ],
            ],
            'database' => [
                'driver' => 'mysql',
                'hostname' => 'localhost',
                'username' => 'opera',
                'password' => '1234',
                'database' => 'opera',
            ],
        ];
    }
}
