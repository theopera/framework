<?php
/**
 * The Opera Framework
 * NotConfiguredException.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 21-9-16
 * @version 1.0
 */

namespace Opera\Component\WebApplication;


use Exception;

class NotConfiguredException extends Exception
{

    /**
     * @param string $component
     * @return NotConfiguredException
     */
    public static function component(string $component) : self
    {
        // Strip the namespace
        $component = substr($component, strrpos($component, '\\') + 1);
        return new NotConfiguredException(sprintf('The component "%s" is currently not configured', $component));
    }
}