<?php
/**
 * The Opera Framework
 * AbstractCommandContainerApplicationTest.php
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

class AbstractCommandContainerApplicationTest extends TestCase
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
     * @var AbstractContainerApplication|MockObject
     */
    protected $application;

    /**
     * @var CommandContainer
     */
    protected $commandContainer;

    /**
     * @var CommandInterface|MockObject
     */
    protected $command;

    /**
     * @var CommandInfo
     */
    protected $commandInfo;

    /**
     * @throws \ReflectionException
     */
    protected function setUp()
    {
        $this->in = $this->createMock(InInterface::class);
        $this->out = $this->createMock(OutInterface::class);
        $this->err = $this->createMock(OutInterface::class);
        $this->context = $this->createMock(Context::class);
        $this->application = $this->getMockForAbstractClass(
            AbstractContainerApplication::class, [$this->context]
        );
        $this->commandContainer = new CommandContainer();
        $this->command = $this->createMock(CommandInterface::class);
        $this->commandInfo = new CommandInfo();
    }

    public function testHelp()
    {
        $this->application
            ->expects(self::once())
            ->method('commands')
            ->willReturn($this->commandContainer);

        $this->command
            ->expects(self::exactly(2))
            ->method('getInfo')
            ->willReturn($this->commandInfo);

        $this->commandInfo
            ->setName('command')
            ->setDescription('description');

        $this->commandContainer->add($this->command);

        $this->out
            ->expects(self::once())
            ->method('writeColorln')
            ->with('command', Color::GREEN);
        $this->out
            ->expects(self::once())
            ->method('writeln')
            ->with("\tdescription");

        $exit = $this->application->start([], $this->in, $this->out);


        self::assertEquals(1, $exit);
    }
    public function testRun()
    {
        $this->application
            ->expects(self::once())
            ->method('commands')
            ->willReturn($this->commandContainer);

        $this->command
            ->expects(self::once())
            ->method('run')
            ->willReturn(88);

        $this->command
            ->expects(self::exactly(1))
            ->method('getInfo')
            ->willReturn($this->commandInfo);

        $this->commandInfo
            ->setName('command')
            ->setDescription('description');

        $this->commandContainer->add($this->command);

        $exit = $this->application->start(['app', 'command']);


        self::assertEquals(88, $exit);
    }
}
