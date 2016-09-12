<?php
/**
 * The Opera Framework
 * ParameterBagTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   27-8-16
 * @version   1.0
 */

namespace Opera\Component\Http;


use PHPUnit\Framework\TestCase;

class ParameterBagTest extends TestCase
{

    public function testAddGetGood()
    {
        $bag = new ParameterBag();
        $bag->add('foo', 'bar');

        self::assertEquals('bar', $bag->get('foo'));
    }

    public function testAddOverrideGood()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        self::assertEquals('bar', $bag->get('foo'));
        $bag->add('foo', 'override', true);
        self::assertEquals('override', $bag->get('foo'));
    }

    public function testAddDuplicateGood()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        $bag->add('foo', 'override');

        self::assertEquals('bar', $bag->get('foo'));
    }


    public function testExportGood()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        $bag->add('bar', 'foo');

        self::assertEquals(['foo'=> 'bar', 'bar' => 'foo'], $bag->export());
    }

    public function testExistsGood()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        self::assertTrue($bag->exists('foo'));
    }

    public function testExistsBad()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        self::assertFalse($bag->exists('bar'));
    }

    public function testGetStringGood()
    {
        $bag = new ParameterBag();
        $bag->add('foo', 'bar');

        self::assertEquals('bar', $bag->getString('foo'));
    }

    public function testGetIntGood()
    {
        $bag = new ParameterBag();
        $bag->add('foo', 1234);

        self::assertEquals(1234, $bag->getInt('foo'));
    }

    public function testGetBoolFromIntGood()
    {
        $bag = new ParameterBag();
        $bag->add('foo', 1);
        $bag->add('bar', 0);

        self::assertTrue($bag->getBool('foo'));
        self::assertFalse($bag->getBool('bar'));
    }

    public function testGetBoolFromBoolGood()
    {
        $bag = new ParameterBag();
        $bag->add('foo', true);
        $bag->add('bar', false);

        self::assertTrue($bag->getBool('foo'));
        self::assertFalse($bag->getBool('bar'));
    }

    public function testGetBoolFromStringGood()
    {
        $bag = new ParameterBag();
        $bag->add('foo', 'true');
        $bag->add('bar', 'false');

        self::assertTrue($bag->getBool('foo'));
        self::assertFalse($bag->getBool('bar'));
    }

}