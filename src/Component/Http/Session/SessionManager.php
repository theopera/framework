<?php
/**
 * The Opera Framework
 * SessionManager.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   18-8-16
 * @version   1.0
 */

namespace Opera\Component\Http\Session;


class SessionManager implements SessionManagerInterface
{
    /**
     * @var SessionInterface
     */
    private $session;


    public function start()
    {
        // if we are in CLI mode we won't start the session
        if (!$this->started() && php_sapi_name() !== 'cli') {
            session_start();
        }
    }

    public function getSession(string $id) : SessionInterface
    {
        if ($this->session === null) {
            // FIXME: This is just temporary, just a quick fix to make it work
            $session = new Session(session_id(), $_SESSION);
            $this->session = $session;
        }

        return $this->session;
    }

    private function started() : bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function __destruct()
    {
        $_SESSION = $this->session->export();
    }
}