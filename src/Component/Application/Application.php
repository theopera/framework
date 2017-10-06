<?php
/**
 * The Opera Framework
 * Application.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   8-7-16
 * @version   1.0
 */

namespace Opera\Component\Application;


use SplFileObject;

abstract class Application
{

    /**
     * @var SplFileObject
     */
    private $in;

    /**
     * @var SplFileObject
     */
    private $out;

    /**
     * @var SplFileObject
     */
    private $err;

    public function __construct()
    {
        $this->in = new SplFileObject('php://stdin');
        $this->out = new SplFileObject('php://stdout');
        $this->err = new SplFileObject('php://stderr');
    }

    public abstract function run();

    public function start()
    {
        $this->run();
    }

    /**
     * @return SplFileObject
     */
    protected function getIn()
    {
        return $this->in;
    }

    /**
     * @return SplFileObject
     */
    protected function getOut()
    {
        return $this->out;
    }

    /**
     * @return SplFileObject
     */
    protected function getErr()
    {
        return $this->err;
    }
    
    
}