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

    /**
     * @param string $name
     * @return bool
     */
    public function hasOption(string $name): bool
    {
        return array_search(sprintf('--%s', $name), $this->arguments) !== false;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getOption(string $name): string
    {
        $indexName = array_search(sprintf('--%s', $name), $this->arguments);
        $indexValue = $indexName + 1;

        if ($indexName !== false &&
            isset($this->arguments[$indexValue]) &&
            strpos($this->arguments[$indexValue], '--') !== 0
        ) {
            return $this->arguments[$indexValue];
        }

        return '';
    }

}