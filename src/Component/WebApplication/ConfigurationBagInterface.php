<?php
/**
 * The Opera Framework
 * ConfigurationBagInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   28-8-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;

interface ConfigurationBagInterface
{
    /**
     * Checks if a parameter exists
     *
     * @param string $key
     *
     * @return bool
     */
    public function exists(string $key) : bool;

    /**
     * Add a parameter to the bag
     *
     * @param string $key
     * @param mixed $value
     */
    public function add(string $key, $value, bool $override = false);

    /**
     * Get the value of a parameter of it does not exits the default
     * value will be returned
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Get the value of a parameter of it does not exits the default
     * value will be returned
     *
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    public function getString(string $key, string $default = null) : string;

    /**
     * Get the value of a parameter of it does not exits the default
     * value will be returned
     *
     * @param string $key
     * @param bool|null $default
     *
     * @return bool
     */
    public function getBool(string $key, bool $default = null) : bool;

    /**
     * Get the value of a parameter of it does not exits the default
     * value will be returned
     *
     * @param string $key
     * @param int|null $default
     *
     * @return int
     */
    public function getInt(string $key, int $default = null) : int;

    /**
     * Returns a new ConfigurationBag with parameters
     * If the section does not exists an empty ConfigurationBag is returned
     *
     * @param string $key
     *
     * @return ConfigurationBagInterface
     */
    public function getSection(string $key) : ConfigurationBagInterface;

    /**
     * Returns all the parameter values
     *
     * @return array
     */
    public function export() : array;
}