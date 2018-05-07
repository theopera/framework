<?php
/**
 * The Opera Framework
 * BrowserTestCase.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   22-10-17
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use Opera\Component\Http\Mime;
use Opera\Component\Http\Request;
use Opera\Component\Http\RequestBuilder;
use Opera\Component\Http\RequestInterface;
use Opera\Component\Http\ResponseInterface;
use PHPUnit\Framework\TestCase;

abstract class BrowserTestCase extends TestCase
{
    abstract protected function getContext() : Context;

    protected function createWebApp() : WebApplication
    {
        return new WebApplication($this->getContext());
    }

    protected function request() : RequestBuilder
    {
        return new RequestBuilder();
    }

    protected function execute(RequestBuilder $builder) : ResponseInterface
    {
        return $this->executeRequest($builder->build());
    }

    protected function executeRequest(RequestInterface $request) : ResponseInterface
    {
        return $this->createWebApp()->run($request);
    }

    /**
     * Does a simple get request
     *
     * @param string $uri
     * @param array  $query
     * @return ResponseInterface
     */
    protected function get(string $uri, array $query) : ResponseInterface
    {
        return $this->execute($this->request()
            ->method(Request::METHOD_GET)
            ->url($uri)
            ->query($query));
    }

    /**
     * Does a get request that expects a json body as response
     * @param string $uri
     * @param array  $query
     * @return ResponseInterface
     */
    protected function getJson(string $uri, array $query) : ResponseInterface
    {
        return $this->execute($this->request()
            ->method(Request::METHOD_GET)
            ->url($uri)
            ->query($query)
            ->accept(Mime::APPLICATION_JSON));
    }

    /**
     * Does a json post request and expects json as response
     *
     * @param string $uri
     * @param array  $data
     * @return ResponseInterface
     */
    protected function postJson(string $uri, array $data) : ResponseInterface
    {
        return $this->execute($this->request()->postJson($uri, $data));
    }

}