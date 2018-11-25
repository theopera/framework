<?php
/**
 * The Opera Framework
 * In.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application\Io;


use SplFileObject;

class In implements InInterface
{
    /**
     * @var SplFileObject
     */
    private $fileObject;

    public static function open(string $path)
    {
        return new self(new SplFileObject($path, 'r'));
    }
    /**
     * Out constructor.
     * @param SplFileObject $fileObject
     */
    public function __construct(SplFileObject $fileObject)
    {
        $this->fileObject = $fileObject;
    }

    /**
     * @param int $length
     * @return string
     */
    public function read(int $length): string
    {
        return $this->fileObject->fread($length);
    }

    /**
     * Returns the next newline
     *
     * @return string
     */
    public function readLine(): string
    {
        return $this->fileObject->fgets();
    }
}