<?php
/**
* The Opera Framework
* ProgressBarTest.php
*
* @author    Marc Heuker of Hoek <me@marchoh.com>
* @copyright 2016 - 2019 All rights reserved
* @license   MIT
* @created   8-7-16
* @version   1.0
*/

namespace Opera\Component\Application;


use Opera\Component\Application\Io\OutInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ProgressBarTest extends TestCase
{

    /**
     * @var OutInterface|MockObject
     */
    protected $out;

    /**
     *
     */
    protected function setUp()
    {
        $this->out = $this->createMock(OutInterface::class);
    }

    public function getProgressBarDataSet(): array
    {
        return [
            [0,  '[                  ]'],
            [1,  '[>                 ]'],
            [2,  '[==>               ]'],
            [3,  '[====>             ]'],
            [4,  '[======>           ]'],
            [5,  '[========>         ]'],
            [6,  '[=========>        ]'],
            [7,  '[===========>      ]'],
            [8,  '[=============>    ]'],
            [9,  '[===============>  ]'],
            [10, '[==================]'],
        ];
    }

    /**
     * @param int $step
     * @param string $result
     * @dataProvider getProgressBarDataSet
     */
    public function testStep(int $step, string $result)
    {
        $this->out->expects(self::once())
            ->method('write')
            ->with("\r" . $result);

        $progressBar = $this->getInstance();
        $progressBar->step($step);
    }

    protected function getInstance(): ProgressBar
    {
        return new ProgressBar($this->out, 0, 10, 20);
    }
}
