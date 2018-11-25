<?php
/**
 * The Opera Framework
 * InInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application\Io;


interface InInterface
{

    public function read(int $length): string;

    public function readLine(): string;
}