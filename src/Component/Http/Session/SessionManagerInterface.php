<?php
/**
 * The Opera Framework
 * SessionManagerInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Http\Session;


interface SessionManagerInterface
{

    /**
     * Starts the underlying session storage
     * @return mixed
     */
    public function start();

    /**
     * @param string $id
     *
     * @throws SessionNotFoundException When the session couldn't be found
     *
     * @return SessionInterface
     */
    public function getSession(string $id) : SessionInterface;
}