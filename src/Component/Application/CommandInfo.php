<?php
/**
 * The Opera Framework
 * CommandInfo.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


class CommandInfo
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var string[]
     */
    private $options = [];

    /**
     * @var string
     */
    private $example = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CommandInfo
     */
    public function setName(string $name): CommandInfo
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CommandInfo
     */
    public function setDescription(string $description): CommandInfo
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string[] $options
     */
    public function setOptions(array $options): CommandInfo
    {
        $this->options = $options;
        return $this;
    }


    /**
     * @return string
     */
    public function getExample(): string
    {
        return $this->example;
    }

    /**
     * @param string $example
     * @return CommandInfo
     */
    public function setExample(string $example): CommandInfo
    {
        $this->example = $example;
        return $this;
    }

}