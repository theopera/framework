<?php
/**
 * The Opera Framework
 * ApplicationTest.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   25-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


use Opera\Component\Application\Io\InInterface;
use Opera\Component\Application\Io\OutInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @var InInterface|MockObject
     */
    protected $in;

    /**
     * @var OutInterface|MockObject
     */
    protected $out;

    /**
     * @var OutInterface|MockObject
     */
    protected $err;

    /**
     * @var Context|MockObject
     */
    protected $context;

    /**
     * @var Application|MockObject
     */
    protected $application;

    /**
     * @throws \ReflectionException
     */
    protected function setUp()
    {
        $this->in = $this->createMock(InInterface::class);
        $this->out = $this->createMock(OutInterface::class);
        $this->err = $this->createMock(OutInterface::class);
        $this->context = $this->createMock(Context::class);
        $this->application = $this->getMockForAbstractClass(Application::class, [$this->context]);
    }


    public function testStart()
    {
        $this->application
            ->expects(self::once())
            ->method('run')
            ->willReturn(1);

        $exit = $this->application->start(['foo' => 'bar'], $this->in, $this->out, $this->err);

        self::assertEquals(1, $exit);
    }


}
