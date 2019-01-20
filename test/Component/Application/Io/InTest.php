<?php
/**
 * The Opera Framework
 * InTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2019 All rights reserved
 * @license   MIT
 * @created   7-1-19
 * @version   1.0
 */

namespace Opera\Component\Application\Io;


use PHPUnit\Framework\TestCase;
use RuntimeException;

class InTest extends TestCase
{

    /**
     * @expectedException  RuntimeException
     */
    public function testOpen()
    {
        In::open('faulty');
    }

    public function testReadLine()
    {
        $in = In::open(__FILE__);
        self::assertEquals('<?php', $in->read(5));
    }

    public function testRead()
    {
        $in = In::open(__FILE__);
        self::assertEquals('<?php' . PHP_EOL, $in->readLine());
    }
}
