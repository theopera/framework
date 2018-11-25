<?php
/**
 * The Opera Framework
 * CommandContainer.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


use ArrayIterator;
use Traversable;

class CommandContainer implements \IteratorAggregate
{

    /**
     * @var CommandInterface[]
     */
    protected $commands = [];

    /**
     * @param CommandInterface $command
     * @return $this
     */
    public function add(CommandInterface $command)
    {
        $this->commands[$command->getInfo()->getName()] = $command;

        return $this;
    }

    /**
     * Finds out if the requested command exists in this container
     *
     * @param string $name
     * @return bool
     */
    public function exists(string $name): bool
    {
        return isset($this->commands[$name]);
    }

    /**
     * @param string $name
     * @return CommandInterface|null
     */
    public function get(string $name):? CommandInterface
    {
        if ($this->exists($name)) {
            return $this->commands[$name];
        }

        return null;
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new ArrayIterator($this->commands);
    }
}