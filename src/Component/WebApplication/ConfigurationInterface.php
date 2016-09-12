<?php
/**
 * The Opera Framework
 * ConfigurationInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   28-8-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


interface ConfigurationInterface
{
    /**
     * Returns a section
     *
     * @param string $key
     *
     * @return ConfigurationBagInterface
     */
    public function getSection(string $key) : ConfigurationBagInterface;
}