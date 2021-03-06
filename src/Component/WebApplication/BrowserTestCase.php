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


use Opera\Component\Http\Header\Headers;
use Opera\Component\Http\HttpException;
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

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws HttpException
     */
    protected function executeRequest(RequestInterface $request) : ResponseInterface
    {
        $response = $this->createWebApp()->run($request);

        if ($response->getStatusCode() === 500) {
            throw new HttpException(500, $response->getBody());
        }

        return $response;
    }
    /**
     * Does a simple get request
     *
     * @param string       $uri
     * @param array        $query
     * @param Headers|null $headers
     * @return ResponseInterface
     */
    protected function get(string $uri, array $query, Headers $headers = null) : ResponseInterface
    {
        return $this->execute($this->request()
            ->method(Request::METHOD_GET)
            ->url($uri)
            ->query($query)
            ->headers($headers));
    }

    /**
     * Does a get request that expects a json body as response
     * @param string $uri
     * @param array  $query
     * @return ResponseInterface
     */
    protected function getJson(string $uri, array $query = [], Headers $headers = null) : ResponseInterface
    {
        return $this->execute($this->request()
            ->method(Request::METHOD_GET)
            ->url($uri)
            ->query($query)
            ->headers($headers)
            ->accept(Mime::APPLICATION_JSON));
    }

    /**
     * Does a json post request and expects json as response
     *
     * @param string $uri
     * @param array  $data
     * @return ResponseInterface
     */
    protected function postJson(string $uri, array $data, Headers $headers = null) : ResponseInterface
    {
        return $this->execute($this->request()->headers($headers)->postJson($uri, $data));
    }

    /**
     * Does a json put request and expects json as response
     *
     * @param string $uri
     * @param array  $data
     * @return ResponseInterface
     */
    protected function putJson(string $uri, array $data, Headers $headers = null) : ResponseInterface
    {
        return $this->execute($this->request()->headers($headers)->putJson($uri, $data));
    }

    /**
     * Does a delete request to the endpoint
     *
     * @param string $uri
     * @param array  $query
     * @return ResponseInterface
     */
    protected function delete(string $uri, array $query = [], Headers $headers = null): ResponseInterface
    {
        return $this->execute($this->request()
            ->method(Request::METHOD_DELETE)
            ->url($uri)
            ->query($query)
            ->headers($headers));
    }
}
