<?php
/**
 * The Opera Framework
 * ArgumentBagTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   26-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


use PHPUnit\Framework\TestCase;

class ArgumentBagTest extends TestCase
{
    public function testHasOption()
    {
        $argumentBag = $this->instance();

        self::assertTrue($argumentBag->hasOption('min'));
        self::assertTrue($argumentBag->hasOption('max'));
        self::assertTrue($argumentBag->hasOption('progress'));
        self::assertFalse($argumentBag->hasOption('not-existing'));
    }

    public function testGetOption()
    {
        $argumentBag = $this->instance();

        self::assertEquals('0', $argumentBag->getOption('min'));
        self::assertEquals('100', $argumentBag->getOption('max'));
        self::assertEquals('', $argumentBag->getOption('progress'));
    }

    protected function instance(array $args = null): ArgumentBag
    {
        if ($args === null) {
            $args = ['app', 'command', '--min', '0', '--progress', '--max', '100'];
        }
        return new ArgumentBag($args);
    }

}
