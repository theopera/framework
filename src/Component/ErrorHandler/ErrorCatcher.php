<?php
/**
 * The Opera Framework
 * ErrorCatcher.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2020 All rights reserved
 * @license   MIT
 * @created   8-3-20
 * @version   1.0
 */

namespace Opera\Component\ErrorHandler;


use Throwable;

class ErrorCatcher
{

    /**
     * @var ErrorHandlerInterface[]
     */
    protected $errorHandlers = [];

    public function addErrorHandler(ErrorHandlerInterface $errorHandler): void
    {
        $this->errorHandlers[] = $errorHandler;
    }

    public function handle(Throwable $throwable): void
    {
        foreach ($this->errorHandlers as $errorHandler) {
            $errorHandler->handle($throwable);
        }
    }

}