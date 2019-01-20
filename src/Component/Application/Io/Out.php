<?php
/**
 * The Opera Framework
 * Out.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application\Io;


use Opera\Component\Application\Color;
use SplFileObject;

class Out implements OutInterface
{
    /**
     * @var SplFileObject
     */
    private $fileObject;


    public static function open(string $path)
    {
        return new self(new SplFileObject($path, 'a'));
    }
    /**
     * Out constructor.
     * @param SplFileObject $fileObject
     */
    public function __construct(SplFileObject $fileObject)
    {
        $this->fileObject = $fileObject;
    }

    public function write(string $line = '', ...$parameters): void
    {
        $this->fileObject->fwrite(vsprintf($line, $parameters));
    }

    public function writeln(string $line = '',  ...$parameters): void
    {
        $this->fileObject->fwrite(vsprintf($line, $parameters) . PHP_EOL);
    }

    public function writeColor(string $line = '', int $color1 = null, int $color2 = null,  ...$parameters): void
    {
        $this->write(
            $this->color($color1) . $this->color($color2) .  $line . $this->color(Color::RESET)
            , ...$parameters
        );
    }

    public function writeColorln(string $line = '', int $color1 = null, int $color2 = null,  ...$parameters): void
    {
        $this->write(
            $this->color($color1) . $this->color($color2) .  $line . $this->color(Color::RESET) . PHP_EOL,
            ...$parameters
        );
    }

    protected function color(int $color = null): string
    {
        if ($color !== null) {
            return sprintf("\e[%dm", $color);
        }

        return '';
    }
}