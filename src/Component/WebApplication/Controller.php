<?php
/**
 * The Opera Framework
 * Controller.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license MIT
 * @created 5/21/16
 * @version 1.0
 */

namespace Opera\Component\WebApplication;


use Opera\Component\Http\HttpException;
use Opera\Component\Http\Session\SessionInterface;
use Opera\Component\Template\Template;
use Opera\Component\Http\Request;
use Opera\Component\Http\Response;

abstract class Controller
{
    /**
     * @var RouteEndpoint
     */
    private $route;

    /**
     * @var Message[]
     */
    private $messages;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Context
     */
    private $context;

    /**
     * Controller constructor.
     *
     * @param RouteEndpoint $route
     * @param Request       $request
     * @param Context       $context
     */
    public function __construct(RouteEndpoint $route, Request $request, Context $context)
    {
        $this->route = $route;
        $this->request = $request;
        $this->context = $context;

        $this->messages = $this->getSession()->get('messages', []);

        $this->init();
    }

    /**
     * Runs on after the constructor
     */
    protected function init()
    {

    }

    /**
     * Add a variable that will be globally accessible in the template
     *
     * @param string $key
     * @param $value
     */
    protected function addGlobal(string $key, $value)
    {
        $template = $this->getContext()->getTemplateEngine();
        $template->addGlobal($key, $value);
    }

    protected function renderView(string $file, array $data = []) : string
    {
        $template = new Template($this->context->getTemplateEngine());
        $template->load($file);

        return $template->render($data);
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    protected function render(array $data = [], $file = null) : Response
    {
        if ($file === null) {
            $file = $this->getTemplateFile();
        }

        // Relative path from the controller?
        if (substr($file, 0, 1) !== '/') {
            $file = $this->getTemplateFile($file);
        }

        $data += [
            'base_url' => 'http://' . $this->request->getHost(),
            '_messages' => $this->messages,
        ];
        $this->messages = [];

        return new Response($this->renderView($file, $data));
    }

    /**
     * Returns the default template file
     *
     * @param string $action The action name, leave null for current action name
     * @return string
     */
    protected function getTemplateFile(string $action = null) : string
    {
        $path = '/controller/' . lcfirst($this->getControllerName()) . '/';

        return $path . ($action ? $action : $this->getActionName());
    }

    //
    // Helper methods
    //

    /**
     * Get the name of the current controller
     *
     * @return string
     */
    protected function getControllerName(){
        return $this->route->getController();
    }

    /**
     * Get the name of the current action
     *
     * @return string
     */
    protected function getActionName()
    {
        return $this->route->getAction();
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    protected function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return string
     */
    protected function getMethod() : string
    {
        return $this->request->getMethod();
    }

    /**
     * @return bool
     */
    protected function isGet() : bool 
    {
        return $this->getMethod() === 'GET';
    }

    /**
     * @return bool
     */
    protected function isPost() : bool 
    {
        return $this->getMethod() === 'POST';
    }

    /**
     * @return bool
     */
    protected function isUpdate() : bool 
    {
        return $this->getMethod() === 'PUT' || (!empty($_POST['_method']) && $_POST['_method'] == 'PUT');
    }

    /**
     * @return bool
     */
    protected function isDelete() : bool
    {
        return $this->getMethod() === 'DELETE';
    }

    /**
     * Is the current request done with ajax?
     * 
     * @return bool
     */
    protected function isAjax() : bool 
    {
        $header = $this->request->getHeaders()->get('X-Requested-With');

        if ($header === null) {
            return false;
        }
        
        return $header->getValue() === 'XMLHttpRequest';
    }

    /**
     * Redirect to a controller
     *
     * @param string $controller
     * @param string $action
     * @param string[] $parameters
     * 
     * @return Response
     */
    protected function redirect($controller = null, $action = 'index', array $parameters = []) : Response
    {
        $host = 'http://'. $_SERVER['HTTP_HOST'];

        if ($controller === null) {

            // Apparently we want to redirect to homepage, so the host will be sufficient
            if ($action === 'index') {
                return $this->redirectUrl($host);
            }
            
            $controller = $this->getControllerName();
        }

        if ($action === 'index') {
            $action = '';
        }else{
            $action = '/' . $action;
        }

        return $this->redirectUrl(sprintf('%s/%s%s', $host, lcfirst($controller), $action), $parameters);
    }

    /**
     * Redirect to a url
     *
     * @param string $url
     * @param string[] $parameters
     *
     * @return Response
     */
    protected function redirectUrl($url, array $parameters = []) : Response
    {
        return Response::redirect($url, $parameters);
    }

    /**
     * @param string $type
     * @param string $message
     * @param null   $title
     */
    protected function addMessage($type, $message, $title = null)
    {
        $this->messages[] = new Message($type, $message, $title);
    }

    protected function getSession() : SessionInterface
    {
        return $this->context->getSessionManager()->getSession(session_id());
    }

    protected function getContext() : Context
    {
        return $this->context;
    }

    /**
     * Has the current user permission for the given action
     *
     * @param string $permission
     * @param bool $return Return a boolean instead of throwing a forbidden exception
     */
    protected function hasPermission(string $permission, bool $return = false)
    {
        $auth = $this->getContext()->getAuthentication();
        $user = $auth->getUser();
        $acl = $this->getContext()->getAccessControlList();

        if (!$acl->hasAccess($user, $permission)) {

            if ($return) {
                return false;
            }else{
                throw HttpException::forbidden('The current user has no permission to this action');
            }
        }

        return true;
    }


    public function __destruct()
    {
          $this->getSession()->add('messages', $this->messages, true);
    }


}