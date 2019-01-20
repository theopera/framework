<?php
/**
 * The Opera Framework
 * ProgressBar.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2019 All rights reserved
 * @license   MIT
 * @created   8-7-16
 * @version   1.0
 */

namespace Opera\Component\Application;


use Opera\Component\Application\Io\OutInterface;


class ProgressBar
{

    /**
     * @var OutInterface
     */
    private $out;
    /**
     * @var int
     */
    protected $min = 0;
    /**
     * @var int
     */
    protected $max = 0;
    /**
     * @var int
     */
    protected $current = 0;
    /**
     * @var int
     */
    protected $width = 0;

    protected $step = 0;

    public static function new(OutInterface $out, int $min = 0, int $max = 100): self
    {
        $width = getenv('COLUMNS') ?: 80;
        return new static($out, $min, $max, $width);
    }

    /**
     * ProgressBar constructor.
     * @param OutInterface $out
     * @param int $min
     * @param int $max
     */
    public function __construct(OutInterface $out, int $min = 0, int $max = 100, int $width = 100)
    {
        $this->min = $this->current = $min;
        $this->max = $max;
        $this->out = $out;
        $this->width = $width;

        $this->step = ($this->width - 2 ) / $this->max;
    }

    public function init()
    {
        $this->draw();
    }

    public function step(int $step = 1)
    {
        $this->current+=$step;
        if ($this->current > $this->max) {
            $this->current = $this->max;
        }

        $this->draw();
    }

    protected function draw()
    {
        $line = '[';

        if ($this->current > 0) {
            $bar = floor( $this->step * $this->current);
            $line .= str_repeat('=', $bar);

            if (strlen($line) > 1 && $this->current !== $this->max) {
                $line[strlen($line) -1] = '>';
            }

            $spaceLength  = $this->width - $bar - 2;
            if ($spaceLength > 0) {
                $line .= str_repeat(' ', $spaceLength);
            }
        } else{
            $line .= str_repeat(' ', $this->width - 2);
        }

        $line .= ']';

        $this->out->write("\r" . $line);
    }


}