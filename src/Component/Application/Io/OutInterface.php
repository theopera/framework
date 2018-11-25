<?php
/**
 * The Opera Framework
 * OutInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application\Io;


interface OutInterface
{

    public function write(string $line, ...$parameters): void;

    public function writeln(string $line, ...$parameters): void;

    public function writeColor(string $line, int $color1 = null,int $color2 = null, ...$parameters): void;

    public function writeColorln(string $line, int $color1 = null,int $color2 = null, ...$parameters): void;

}