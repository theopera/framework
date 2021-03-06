<?php
/**
 * The Opera Framework
 * RequestBuilder.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   22-10-17
 * @version   1.0
 */

namespace Opera\Component\Http;


use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;

class RequestBuilder
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Headers
     */
    protected $headers;

    /**
     * @var string[]
     */
    protected $query = [];

    /**
     * @var string[]
     */
    protected $post = [];

    /**
     * @var string
     */
    protected $content;

    /**
     * RequestBuilder constructor.
     */
    public function __construct()
    {
        $this->headers = new Headers();
    }

    /**
     * @param Headers|null $headers
     * @return $this
     */
    public function headers(Headers $headers = null)
    {
        if ($headers) {
            $this->headers = $headers;
        }

        return $this;
    }

    /**
     * Set a Method
     *
     * @param string $method
     * @return RequestBuilder
     */
    public function method(string $method) : RequestBuilder
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Set the url
     *
     * @param string $url
     * @return RequestBuilder
     */
    public function url(string $url) : RequestBuilder
    {
        $this->url = $url;

        // Also store the query parameters if present
        $queryString = parse_url($this->url, PHP_URL_QUERY);
        parse_str($queryString, $query);
        if ($query) {
            $this->query = $query;
        }

        return $this;
    }

    /**
     * Set the query parameters
     *
     * @param array $query
     * @return RequestBuilder
     */
    public function query(array $query = []): RequestBuilder
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param string $type
     * @return RequestBuilder
     */
    public function contentType(string $type) : RequestBuilder
    {
        $this->headers->add(new Header('Content-Type', $type));

        return $this;
    }

    /**
     * @param string $accept
     * @return RequestBuilder
     */
    public function accept(string $accept) : RequestBuilder
    {
        $this->headers->add(new Header('Accept', $accept));

        return $this;
    }

    /**
     * @param string $content
     * @return RequestBuilder
     */
    public function content(string $content) : RequestBuilder
    {
        $this->content = $content;

        return $this;
    }

    public function postJson(string $url, array $data) : RequestBuilder
    {

        $this->method(Request::METHOD_POST)
            ->url($url)
            ->contentType(Mime::APPLICATION_JSON)
            ->accept(Mime::APPLICATION_JSON)
            ->content(json_encode($data));

        return $this;
    }

    public function putJson(string $url, array $data) : RequestBuilder
    {
        $this->method(Request::METHOD_PUT)
            ->url($url)
            ->contentType(Mime::APPLICATION_JSON)
            ->accept(Mime::APPLICATION_JSON)
            ->content(json_encode($data));

        return $this;
    }

    public function build() : RequestInterface
    {
        $request = new Request($this->method, $this->url, $this->headers, $this->query, $this->post);
        $request->setContent($this->content ?? '');

        return $request;
    }
}
