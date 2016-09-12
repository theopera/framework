<?php
/**
 * The Opera Framework
 * ErrorHandler.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   12-9-16
 * @version   1.0
 */

namespace Opera\Component\ErrorHandler;

use Opera\Component\ErrorHandler\Exception\CompileWarningException;
use Opera\Component\ErrorHandler\Exception\ErrorException;
use Opera\Component\ErrorHandler\Exception\WarningException;
use Opera\Component\ErrorHandler\Exception\ParseException;
use Opera\Component\ErrorHandler\Exception\NoticeException;
use Opera\Component\ErrorHandler\Exception\CoreErrorException;
use Opera\Component\ErrorHandler\Exception\CoreWarningException;
use Opera\Component\ErrorHandler\Exception\CompileErrorException;
use Opera\Component\ErrorHandler\Exception\UserErrorException;
use Opera\Component\ErrorHandler\Exception\UserWarningException;
use Opera\Component\ErrorHandler\Exception\UserNoticeException;
use Opera\Component\ErrorHandler\Exception\StrictException;
use Opera\Component\ErrorHandler\Exception\RecoverableErrorException;
use Opera\Component\ErrorHandler\Exception\DeprecatedException;
use Opera\Component\ErrorHandler\Exception\UserDeprecatedException;

class ErrorHandler
{

    public static function init()
    {
        $handler = new ErrorHandler();
        set_error_handler([$handler, 'handle']);
    }

    /**
     * @param int    $level
     * @param string $message
     * @param string $file
     * @param int    $line
     * @param array  $context
     * @throws CompileErrorException
     * @throws CompileWarningException
     * @throws CoreErrorException
     * @throws CoreWarningException
     * @throws DeprecatedException
     * @throws ErrorException
     * @throws NoticeException
     * @throws ParseException
     * @throws RecoverableErrorException
     * @throws StrictException
     * @throws UserDeprecatedException
     * @throws UserErrorException
     * @throws UserNoticeException
     * @throws UserWarningException
     * @throws WarningException
     */
    public function handle(int $level, string $message, string $file, int $line, array $context = [])
    {
        switch($level)
        {
            case E_ERROR:               throw new ErrorException            ($message, 0, $level, $file, $line);
            case E_WARNING:             throw new WarningException          ($message, 0, $level, $file, $line);
            case E_PARSE:               throw new ParseException            ($message, 0, $level, $file, $line);
            case E_NOTICE:              throw new NoticeException           ($message, 0, $level, $file, $line);
            case E_CORE_ERROR:          throw new CoreErrorException        ($message, 0, $level, $file, $line);
            case E_CORE_WARNING:        throw new CoreWarningException      ($message, 0, $level, $file, $line);
            case E_COMPILE_ERROR:       throw new CompileErrorException     ($message, 0, $level, $file, $line);
            case E_COMPILE_WARNING:     throw new CompileWarningException   ($message, 0, $level, $file, $line);
            case E_USER_ERROR:          throw new UserErrorException        ($message, 0, $level, $file, $line);
            case E_USER_WARNING:        throw new UserWarningException      ($message, 0, $level, $file, $line);
            case E_USER_NOTICE:         throw new UserNoticeException       ($message, 0, $level, $file, $line);
            case E_STRICT:              throw new StrictException           ($message, 0, $level, $file, $line);
            case E_RECOVERABLE_ERROR:   throw new RecoverableErrorException ($message, 0, $level, $file, $line);
            case E_DEPRECATED:          throw new DeprecatedException       ($message, 0, $level, $file, $line);
            case E_USER_DEPRECATED:     throw new UserDeprecatedException   ($message, 0, $level, $file, $line);
        }
    }
}