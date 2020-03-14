<?php
/**
 * The Opera Framework
 * ErrorHandlerInterface.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2020 All rights reserved
 * @license   MIT
 * @created   8-3-20
 * @version   1.0
 */

namespace Opera\Component\ErrorHandler;


use Throwable;

interface ErrorHandlerInterface
{
    /**
     * All Errors and Exceptions thrown by the application are routed through here
     *
     * @param Throwable $throwable
     */
    public function handle(Throwable $throwable): void;
}