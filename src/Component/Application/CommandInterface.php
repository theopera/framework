<?php
/**
 * The Opera Framework
 * CommandInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


interface CommandInterface extends Runnable
{

    /**
     * Get info about the command
     *
     * @return CommandInfo
     */
    public function getInfo(): CommandInfo;

}