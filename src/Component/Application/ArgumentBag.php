<?php
/**
 * The Opera Framework
 * Arguments.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


class ArgumentBag
{
    /**
     * @var string[]
     */
    private $arguments = [];

    /**
     * ArgumentBag constructor.
     * @param string[] $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function count(): int
    {
        return count($this->arguments);
    }

    /**
     * @param int $index
     * @return string
     */
    public function get(int $index): string
    {
        return $this->arguments[$index];
    }


}