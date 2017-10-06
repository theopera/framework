<?php
/**
 * The Opera Framework
 * Bootstrap.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/21/16
 * @version 1.0
 */

namespace Opera\Component\WebApplication;


use Opera\Component\Authentication\AuthenticationException;
use Opera\Component\Authentication\AuthenticationInterface;
use Opera\Component\Http\Header\Header;
use Opera\Component\Http\HttpException;
use Opera\Component\Http\JsonResponse;
use Opera\Component\Http\Middleware\MiddlewareCollection;
use Opera\Component\Http\Mime;
use Opera\Component\Http\RequestInterface;
use Opera\Component\Http\ResponseInterface;
use Opera\Component\Template\PhpEngine;
use Opera\Component\Template\RenderInterface;
use Opera\Component\Template\Template;
use Opera\Component\Http\Middleware\MiddlewareCollectionInterface;
use Opera\Component\Http\Middleware\MiddlewareInterface;
use ReflectionClass;
use Opera\Component\Http\Response;
use Throwable;

class WebApplication implements MiddlewareInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ConfigurationBagInterface
     */
    protected $config;

    /**
     * WebApplication constructor.
     *
     * @param RequestInterface $request
     * @param Context $context
     */
    public function __construct(RequestInterface $request, Context $context)
    {
        $this->request = $request;
        $this->context = $context;

        $this->config = $context->getConfig()->getSection('general');
    }

    /**
     * @return ResponseInterface
     */
    public function run() : ResponseInterface
    {

        try{
            $this->setup();

            $collection = new MiddlewareCollection($this->request);
            $collection = $this->context->getMiddlewareCollection($collection);
            // Add the web application itself at the end of the middleware collection
            $collection->add($this);

            // Go through the chain of middleware and return its response
            $response = $collection->next();

            if ($this->config->getBool('expose-opera', true)) {
                $response->getHeaders()->add(new Header('X-Powered-By', 'The Opera Framework'), true);
            }

            return $response;

        }catch (Throwable $e){
            return $this->errorPage($e);
        }

    }

    public function handle(MiddlewareCollectionInterface $collection, RequestInterface $request) : ResponseInterface
    {
        // If we have a trailing slash we will do redirect (e.g. /bla/bla/ -> /bla/bla)
        if (strlen($this->request->getPathInfo()) > 1 && substr($this->request->getPathInfo(), -1) === '/') {
            // Because we do a Permanent Redirect any post parameters will be resend to the redirect url
            return Response::redirect(
                substr($this->request->getPathInfo(), 0, -1),
                [],
                Response::STATUS_PERMANENTLY_REDIRECT
            );
        }

        $router = new Router($this->context);
        $route = $router->resolve($this->request);
        $endPoint = $route->getEndPoint();

        if (!$endPoint->isCallable()) {
            throw HttpException::notFound(
                sprintf('The request "%s" was not found', substr($this->request->getUri(), 0, 64))
            );
        }

        $fullQuantifiedName = $endPoint->getFullyQualifiedName();
        $controller = new $fullQuantifiedName($endPoint, $this->request, $this->context);

        $mapper = $this->mapQueryToActionParameters($endPoint);
        $action = $endPoint->getAction(true);
        
        return call_user_func_array([$controller, $action], $mapper);
    }

    private function setup()
    {
        // Start our session storage
        $sessionManager = $this->context->getSessionManager();
        $sessionManager->start();

        $template = $this->context->getTemplateEngine();
        $auth = $this->context->getAuthentication();
        $config = $this->context->getConfig();

        $user = $auth ? $auth->getUser() : null;

        $globals = [
            'environment' => $this->context->getEnvironment(),
            'var' => $config->getSection('templating')->export(),
            'user' => $user,
        ];

        $template->addGlobal('app', $globals);
    }

    /**
     * Maps all the query parameters to the controller action parameters
     *
     * @param RouteEndpoint $route
     *
     * @return string[]
     * @throws HttpException
     */
    private function mapQueryToActionParameters(RouteEndpoint $route) : array
    {
        $reflection = new ReflectionClass($route->getFullyQualifiedName());
        $method = $reflection->getMethod($route->getAction(true));
        $query = $this->request->getQuery();

        $mapper = [];
        foreach ($method->getParameters() as $parameter) {
            $defaultValue = null;
            if ($parameter->isDefaultValueAvailable()) {
                $defaultValue = $parameter->getDefaultValue();
            }

            $value = $query->get($parameter->getName(), $defaultValue);

            // We are missing a required parameter, so this is a bad request
            if ($value === null && !$parameter->allowsNull()) {
                throw HttpException::badRequest();
            }

            $mapper[$parameter->getName()] = $value;
        }

        return $mapper;
    }

    private function errorPage(Throwable $throwable) : Response
    {
        $statusCode = 500;
        $exception = $throwable;
        if ($throwable instanceof HttpException) {
            $statusCode = $throwable->getStatusCode();
            if ($throwable->getPrevious() !== null) {
                $exception = $throwable->getPrevious();
            }
        }

        if ($this->request->getHeaders()->get('Accept')->contains(Mime::APPLICATION_JSON)) {
            return $this->errorPageJson($statusCode, $exception);
        }

        return $this->errorPageHtml($statusCode, $exception);
    }

    private function errorPageJson(int $statusCode, Throwable $throwable) : Response
    {
        return new JsonResponse([
            'message' => $throwable->getMessage(),
            'file' => $throwable->getFile(),
            'line' => $throwable->getLine(),
            'stacktrace' => $throwable->getTrace(),
        ], JSON_PRETTY_PRINT, $statusCode);
    }

    private function errorPageHtml(int $statusCode, Throwable $throwable) : Response
    {
        $data = [
            'environment' => $this->context->getEnvironment(),
            'throwable' => $throwable,
            'statusCode' => $statusCode,
            'statusText' => Response::getStatusText($statusCode),
        ];

        $engine = $this->getErrorRender();
        $template = new Template($engine);
        $template->load('error');
        
        return new Response($template->render($data), $statusCode);
    }

    private function getErrorRender() : RenderInterface
    {
        $customErrorPage = $this->config->getBool('custom-error-page', false);
        if ($customErrorPage) {
            $viewDir = $this->context->getViewDirectory();
        }else{
            $viewDir = __DIR__ . '/view';
        }

        return new PhpEngine($viewDir);
    }
}
