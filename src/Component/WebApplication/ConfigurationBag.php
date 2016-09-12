<?php
/**
 * The Opera Framework
 * ConfigurationBag.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   28-8-16
 * @version   1.0
 */


namespace Opera\Component\WebApplication;


class ConfigurationBag implements ConfigurationBagInterface
{

    /**
     * @var string[]
     */
    protected $parameters;

    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Checks if a parameter exists
     *
     * @param string $key
     *
     * @return bool
     */
    public function exists(string $key) : bool
    {
        return isset($this->parameters[$key]);
    }

    /**
     * Add a parameter to the bag
     *
     * @param string $key
     * @param mixed  $value
     */
    public function add(string $key, $value, bool $override = false)
    {
        if (!$override && $this->exists($key)) {
            return;
        }

        $this->parameters[$key] = $value;
    }

    /**
     * Get the value of a parameter of it does not exits the default
     * value will be returned
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if ($this->exists($key)) {
            return $this->parameters[$key];
        }

        return $default;
    }

    /**
     * Get the value of a parameter of it does not exits the default
     * value will be returned
     *
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    public function getString(string $key, string $default = null) : string
    {
        return (string) $this->get($key, $default);
    }

    /**
     * Get the boolean value of a parameter of it does not exits the default
     * value will be returned
     *
     * it also interpret string values 'true' and 'false' as a bool
     *
     * @param string $key
     * @param bool|null $default
     * @return bool
     */
    public function getBool(string $key, bool $default = null) : bool
    {
        if ($this->getString($key) === 'true') {
            return true;
        }

        if ($this->getString($key) === 'false') {
            return false;
        }

        return (bool) $this->get($key, $default);
    }

    /**
     * Get the value of a parameter of it does not exits the default
     * value will be returned
     *
     * @param string $key
     * @param int|null $default
     * @return int
     */
    public function getInt(string $key, int $default = null) : int
    {
        return (int) $this->get($key, $default);
    }

    /**
     * Returns a new ConfigurationBag with parameters
     * If the section does not exists an empty ConfigurationBag is returned
     *
     * @param string $key
     *
     * @return ConfigurationBagInterface
     */
    public function getSection(string $key) : ConfigurationBagInterface
    {
        return new ConfigurationBag(isset($this->parameters[$key]) ? $this->parameters[$key] : []);
    }

    /**
     * Returns all the parameter values
     *
     * @return array
     */
    public function export() : array
    {
        return $this->parameters;
    }
}