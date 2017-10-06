<?php
/**
 * The Opera Framework
 * Route.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   13-7-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


class Route
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var RouteEndpoint
     */
    private $endPoint;

    /**
     * Route constructor.
     *
     * @param string        $path
     * @param RouteEndpoint $endPoint
     */
    public function __construct(string $path, RouteEndpoint $endPoint)
    {
        $this->path = $path;
        $this->endPoint = $endPoint;
    }

    /**
     * @return string
     */
    public function getPath() : string 
    {
        return $this->path;
    }

    /**
     * @return RouteEndpoint
     */
    public function getEndPoint() : RouteEndpoint
    {
        return $this->endPoint;
    }
    
    


}