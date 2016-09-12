<?php
/**
 * The Opera Framework
 * Configuration.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   27-8-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


class Configuration implements ConfigurationInterface
{

    protected $configuration = [];

    public function __construct(array $configuration = [])
    {
        $this->configuration = $configuration;
    }

    /**
     * Returns a section
     *
     * @param string $key
     *
     * @return ConfigurationBagInterface
     */
    public function getSection(string $key) : ConfigurationBagInterface
    {
        return new ConfigurationBag(isset($this->configuration[$key]) ? $this->configuration[$key] : []);
    }

}