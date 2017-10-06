<?php
/**
 * The Opera Framework
 * RouteEndPoint.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/21/16
 * @version 1.0
 */

namespace Opera\Component\WebApplication;


class RouteEndpoint
{
    
    /**
    * @var string
    */
    private $namespace;
    
    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $method;

    /**
     * RouteEndPoint constructor.
     *
     * @param string $namespace
     * @param string $controller
     * @param string $action
     * @param string $method
     */
    public function __construct(string $namespace, string $controller, string $action, string $method)
    {
        $this->namespace = $namespace;
        $this->controller = ucfirst($controller);
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getFullyQualifiedName()
    {
        return $this->namespace . $this->getController(true);
    }
    
    /**
     * @param bool $full Get the full controller name?
     * @return string
     */
    public function getController(bool $full = false) : string
    {
        return $this->controller . ($full ? 'Controller' : '');
    }

    /**
     * @param bool $full Get the full action name?
     * @return string
     */
    public function getAction(bool $full = false) : string
    {
        return $this->action . ($full ? ucfirst(strtolower($this->method)) : '');
    }

    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * Is this route callable?
     * 
     * @return bool
     */
    public function isCallable() : bool 
    {
        return is_callable(
            [
                $this->namespace . $this->getController(true),
                $this->getAction(true)
            ]
        );
    }
}