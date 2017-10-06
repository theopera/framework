<?php
/**
 * The Opera Framework
 * Router.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   13-7-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use Opera\Component\Http\Request;
use Opera\Component\Http\RequestInterface;

class Router
{
    /**
     * @var RouteCollection[]
     */
    private $routeCollections = [];
    
    /**
     * @var Context
     */
    private $context;

    private $types = [
        'i' => '[0-9]++',
        's' => '[a-zA-Z]++',
        'a' => '[a-zA-Z0-9-]++',
        '*' => '*',
    ];

    public function __construct(Context $context)
    {
        $this->context = $context;

        // Add the route collection from the main project
        $this->addRouteCollection($context->getRouteCollection());
    }

    public function addRouteCollection(RouteCollection $collection)
    {
        $this->routeCollections[] = $collection;
    }

    public function resolve(RequestInterface $request) : Route
    {
        foreach ($this->routeCollections as $routeCollection) {
            foreach ($routeCollection->getRoutes() as $route) {
                $result = [];
                preg_match_all($this->compileRoutePath($route->getPath()), $request->getPathInfo(), $result);

                $found = array_shift($result);

                // We have a matching route
                if (!empty($found)) {
                    array_pop($result);

                    if ($request->getMethod() !== $route->getEndPoint()->getMethod()) {
                        continue;
                    }

                    // Add the parameters to the request
                    foreach ($result as $key => $value) {
                        $request->getQuery()->add($key, $value[0]);
                    }

                    return $route;
                }

            }
        }

        return $this->fallBackRoute($request);
    }

    private function compileRoutePath(string $pattern) : string
    {
        return '|^' . preg_replace_callback('|\[([ais\*])\:([a-zA-Z]*)\]|', function ($matches){
            list(, $type, $name) = $matches;
            return '(?<' . $name . '>' . $this->types[$type] . ')';
        }, $pattern) . '$|';
    }

    /**
     * If we cannot match a Route with the RouteCollection
     * we will try to find a Controller & Action that matches the uri
     *
     * @param RequestInterface $request
     * @return Route
     */
    private function fallBackRoute(RequestInterface $request) : Route
    {
        $parts = explode('/', $request->getPathInfo());

        if (count($parts) == 2 && empty($parts[1])) {
            return $this->getDefaultRoute($request);
        }
        $actionName = 'index';

        $controllerName = ucfirst($parts[1]);
        if (count($parts) > 2) {
            $actionName = $parts[2];
        }
        
        $endPoint = new RouteEndpoint(
            $this->context->getControllerNamespace(),
            $controllerName,
            $actionName,
            $request->getMethod());
        
        return new Route('/' . $parts[1] . '/' . $actionName, $endPoint);
    }

    private function getDefaultRoute(RequestInterface $request) : Route
    {
        $endPoint = new RouteEndpoint($this->context->getControllerNamespace(), 'Default', 'index', $request->getMethod());

        return new Route('/', $endPoint);
    }
}