<?php
/**
 * The Opera Framework
 * OutTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2019 All rights reserved
 * @license   MIT
 * @created   7-1-19
 * @version   1.0
 */

namespace Opera\Component\Application\Io;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use SplFileObject;

class OutTest extends TestCase
{

    /**
     * @var SplFileObject|MockObject
     */
    protected $splFileObject;

    protected function setUp()
    {
        $this->splFileObject = $this->getMockBuilder(SplFileObject::class)
            ->setConstructorArgs(['php://memory', 'a'])
            ->getMock();
    }


    /**
     * @expectedException RuntimeException
     */
    public function testOpen()
    {
        Out::open('/faulty');
    }

    public function testWrite()
    {
        $out = new Out($this->splFileObject);

        $this->splFileObject
            ->expects(self::once())
            ->method('fwrite')
            ->with('Hello');

        $out->write('Hello');
    }

    public function testWriteln()
    {
        $out = new Out($this->splFileObject);

        $this->splFileObject
            ->expects(self::once())
            ->method('fwrite')
            ->with('Hello' . PHP_EOL);

        $out->writeln('Hello');

    }
}
