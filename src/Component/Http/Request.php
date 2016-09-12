<?php
/**
 * The Opera Framework
 * Request.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   23-5-16
 * @version   1.0
 */


namespace Opera\Component\Http;


use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;

class Request implements RequestInterface
{

    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_UPDATE = 'UPDATE';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $pathInfo;
    
    /**
     * @var Headers
     */
    private $headers;

    /**
     * @var ParameterBagInterface
     */
    private $query;
    
    /**
     * @var ParameterBagInterface
     */
    private $post;

    /**
     * @var Cookies
     */
    private $cookies;

    /**
     * Client ip address
     *
     * @var string
     */
    private $ip = '127.0.0.1';

    /**
     * @param Headers $headers
     * @param string  $body
     */
    public function __construct(
        string $method = Request::METHOD_GET,
        string $uri = '/',
        Headers $headers = null,
        array $query = [],
        array $post = []
    ) {
        $this->method = $method;
        $this->headers = $headers ?? new Headers();
        $this->query = new ParameterBag($query);
        $this->post  = new ParameterBag($post);

        $this->cookies = new Cookies();

        $this->setUri($uri);
    }

    /**
     * @return Headers | Header[]
     */
    public function getHeaders() : Headers
    {
        return $this->headers;
    }

    /**
     * @return ParameterBag
     */
    public function getQuery() : ParameterBagInterface
    {
        return $this->query;
    }

    /**
     * @return ParameterBag
     */
    public function getPost() : ParameterBagInterface
    {
        return $this->post;
    }

    public function getCookies() : Cookies
    {
        return $this->cookies;
    }

    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @return bool
     */
    public function isHead() : bool
    {
        return $this->method === self::METHOD_HEAD;
    }

    /**
     * @return bool
     */
    public function isGet() : bool
    {
        return $this->method === self::METHOD_GET;
    }

    /**
     * @return bool
     */
    public function isPost() : bool
    {
        return $this->method === self::METHOD_POST;
    }

    /**
     * @return bool
     */
    public function isUpdate() : bool
    {
        return $this->method === self::METHOD_UPDATE;
    }

    /**
     * @return bool
     */
    public function isPatch() : bool
    {
        return $this->method === self::METHOD_PATCH;
    }

    /**
     * @return bool
     */
    public function isDelete() : bool
    {
        return $this->method === self::METHOD_DELETE;
    }

    /**
     * @return bool
     */
    public function isOptions() : bool
    {
        return $this->method === self::METHOD_OPTIONS;
    }

    /**
     * @return string
     */
    public function getUri() : string
    {
        return $this->uri;
    }

    /**
     * Get the path info
     * which is the uri without the query parameters
     * @return string
     */
    public function getPathInfo()
    {
        if ($this->pathInfo === null) {
            $end = strpos($this->uri, '?');

            if ($end === false) {
                $this->pathInfo = $this->uri;
            }else{
                $this->pathInfo = substr($this->uri, 0, $end);
            }

            if (empty($this->pathInfo)) {
                $this->pathInfo = '/';
            }
        }
        
        return $this->pathInfo;
    }

    /**
     * @return string
     */
    public function getHost() : string
    {
        return $this->headers->get('Host')->getValue();
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri)
    {
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . $uri;
        }

        $this->uri = $uri;
    }

    static public function createFromGlobals() : Request
    {
        $headers = new Headers();

        foreach ($_SERVER as $name => $value) {
            if (strpos($name, 'HTTP_') !== 0) {
                continue;
            }

            $name = ucwords(strtolower(str_replace('_', '-', substr($name, 5))), '-');

            $headers->add(new Header($name, $value));
        }

        $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $headers, $_GET, $_POST);
        $request->setIp($_SERVER['REMOTE_ADDR']);

        return $request;
    }

    public function __toString()
    {
        return  $this->method . ' ' . $this->uri . ' HTTP/1.1' . Header::NEW_LINE .
            $this->headers          . Header::NEW_LINE . Header::NEW_LINE;
    }


    public static function createFromString(string $string) : Request
    {
        $lines = explode(Header::NEW_LINE, $string);
        list($method, $uri, $httpVersion) = explode(' ', array_shift($lines), 3);

        $headers = new Headers();

        foreach ($lines as $line) {
            if($line !== ''){
                list($name, $value) = explode(': ', $line, 2) + [null, null];

                if($name !== null && $value !== null){
                    $headers->add(new Header($name, $value));
                }

            }
        }

        // Parse the query if available
        $query = [];
        $startQuery = strpos($uri, '?');
        if ($startQuery !== false && strlen($uri) >= $startQuery + 1) {
            $queryString = substr($uri, $startQuery + 1);
            if ($queryString !== false) {
                parse_str($queryString, $query);
            }
        }

        return new Request($method, $uri, $headers, $query, []);
    }

    /**
     * @inheritdoc
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @inheritdoc
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
    }
}