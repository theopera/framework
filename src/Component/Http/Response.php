<?php
/**
 * The Opera Framework
 * Response.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/22/16
 * @version 1.0
 */

namespace Opera\Component\Http;

use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;

class Response implements ResponseInterface
{

    const HTTP_VERSION = '1.1';

    const STATUS_CONTINUE = 100;
    const STATUS_SWITCHING_PROTOCOLS = 101;
    const STATUS_PROCESSING = 102;
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_ACCEPTED = 202;
    const STATUS_NON_AUTHORITATIVE_INFORMATION = 203;
    const STATUS_NO_CONTENT = 204;
    const STATUS_RESET_CONTENT = 205;
    const STATUS_PARTIAL_CONTENT = 206;
    const STATUS_MULTI_STATUS = 207;
    const STATUS_ALREADY_REPORTED = 208;
    const STATUS_IM_USED = 226;
    const STATUS_MULTIPLE_CHOICES = 300;
    const STATUS_MOVED_PERMANENTLY = 301;
    const STATUS_FOUND = 302;
    const STATUS_SEE_OTHER = 303;
    const STATUS_NOT_MODIFIED = 304;
    const STATUS_USE_PROXY = 305;
    const STATUS_RESERVED = 306;
    const STATUS_TEMPORARY_REDIRECT = 307;
    const STATUS_PERMANENTLY_REDIRECT = 308;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_PAYMENT_REQUIRED = 402;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_METHOD_NOT_ALLOWED = 405;
    const STATUS_NOT_ACCEPTABLE = 406;
    const STATUS_PROXY_AUTHENTICATION_REQUIRED = 407;
    const STATUS_REQUEST_TIMEOUT = 408;
    const STATUS_CONFLICT = 409;
    const STATUS_GONE = 410;
    const STATUS_LENGTH_REQUIRED = 411;
    const STATUS_PRECONDITION_FAILED = 412;
    const STATUS_REQUEST_ENTITY_TOO_LARGE = 413;
    const STATUS_REQUEST_URI_TOO_LONG = 414;
    const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;
    const STATUS_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const STATUS_EXPECTATION_FAILED = 417;
    const STATUS_I_AM_A_TEAPOT = 418;
    const STATUS_UNPROCESSABLE_ENTITY = 422;
    const STATUS_LOCKED = 423;
    const STATUS_FAILED_DEPENDENCY = 424;
    const STATUS_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;
    const STATUS_UPGRADE_REQUIRED = 426;
    const STATUS_PRECONDITION_REQUIRED = 428;
    const STATUS_TOO_MANY_REQUESTS = 429;
    const STATUS_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_NOT_IMPLEMENTED = 501;
    const STATUS_BAD_GATEWAY = 502;
    const STATUS_SERVICE_UNAVAILABLE = 503;
    const STATUS_GATEWAY_TIMEOUT = 504;
    const STATUS_VERSION_NOT_SUPPORTED = 505;
    const STATUS_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;
    const STATUS_INSUFFICIENT_STORAGE = 507;
    const STATUS_LOOP_DETECTED = 508;
    const STATUS_NOT_EXTENDED = 510;
    const STATUS_NETWORK_AUTHENTICATION_REQUIRED = 511;

    /**
     * Status codes translation table.
     *
     * @var string[]
     */
    protected static $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Reserved for WebDAV advanced collections expired proposal',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates (Experimental)',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    );

    /**
     * @var Headers
     */
    protected $headers;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $body;

    /**
     * @param int $statusCode
     *
     * @return string
     */
    public static function getStatusText(int $statusCode) : string
    {
        return self::$statusTexts[$statusCode] ?? '';
    }

    /**
     * Redirect to a url
     *
     * @param string $url
     * @param string[] $parameters
     * @param int $statusCode
     *
     * @return Response
     */
    public static function redirect($url, array $parameters = [], int $statusCode = Response::STATUS_MOVED_PERMANENTLY) : Response
    {
        if (!empty($parameters)) {
            $url = $url . '?' . http_build_query($parameters);
        }

        $headers = new Headers();
        $headers->add(new Header('Location', $url));

        return new Response('', $statusCode, $headers);
    }

    /**
     * Create a Response object from a string
     *
     * @param string $string
     * @return Response
     */
    public static function createFromString(string $string) : Response
    {

        $lines = explode("\r\n", $string);
        list($httpVersion, $statusCode, $statusText) = explode(' ', array_shift($lines), 3);

        $headers = new Headers();

        foreach ($lines as $index => $line) {
            unset($lines[$index]);

            if($line !== ''){
                $headers->add(Header::createFromString($line));
            }else{
                // We are done with the header part
                break;
            }
        }

        return new Response(implode("\r\n", $lines), $statusCode, $headers);
    }

    public function __construct(string $body, int $statusCode = Response::STATUS_OK, Headers $headers = null)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers ?? new Headers();
        $this->body = $body;

        $this->setBaseHeaders();
    }

    /**
     * Returns the status code
     * 0 will be provided if there is no status code
     *
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->statusCode ?? 0;
    }

    /**
     * Get the complete status line
     *
     * @return string
     */
    public function getStatusLine() : string
    {
        return sprintf('HTTP/%s %s %s', self::HTTP_VERSION, $this->statusCode, self::getStatusText($this->statusCode));
    }

    /**
     * @return Headers
     */
    public function getHeaders() : Headers
    {
        return $this->headers;
    }

    /**
     * Returns the content type.
     * If no Content-Type header was given plain/text will be returned.
     *
     * @return string
     */
    public function getContentType() : string
    {
        return $this->headers->get('Content-Type')->getValue() ?? Mime::TEXT_PLAIN;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * Sends the response to the web server
     *
     * @return void
     */
    public function send()
    {

        if (headers_sent()) {
            throw new HttpException(Response::STATUS_INTERNAL_SERVER_ERROR, 'Headers already send');
        }

        header($this->getStatusLine());

        foreach ($this->headers as $header) {
            header($header);
        }

        echo $this->body;
    }

    public function __toString()
    {
        return  $this->getStatusLine() . Header::NEW_LINE .
        $this->headers         . Header::NEW_LINE . Header::NEW_LINE .
        $this->body;
    }

    /**
     * Sets some basic headers.
     * Those who are already set will be left alone.
     */
    protected function setBaseHeaders()
    {
        $this->headers->add(new Header('Content-Type', Mime::TEXT_HTML), false);
    }
}