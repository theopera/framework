<?php
/**
 * The Opera Framework
 * RouteCollection.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   12-7-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use Opera\Component\Http\Request;

class RouteCollection
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * RouteCollection constructor.
     *
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Add a new route to the collection
     * 
     * @param string $path
     * @param string $controller
     * @param string $action
     * @param string $method
     *
     * @return $this
     */
    public function addRoute(string $path, string $controller, string $action = 'index', string $method = Request::METHOD_GET) : self
    {
        $endPoint = new RouteEndpoint($this->namespace, $controller, $action, $method);
        $this->routes[] = new Route($path, $endPoint);
        
        return $this;
    }

    /**
     * @return Route[]
     */
    public function getRoutes() : array 
    {
        return $this->routes;
    }


}