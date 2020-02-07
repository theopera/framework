<?php
/**
 * The Opera Framework
 * Context.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license   MIT
 * @created   7-7-16
 * @version   1.0
 */

namespace Opera\Component\WebApplication;


use Opera\Component\Application\Context as ApplicationContext;
use Opera\Component\Authentication\AuthenticationInterface;
use Opera\Component\Authorization\AccessControlList;
use Opera\Component\Authorization\AccessControlListInterface;
use Opera\Component\Http\Session\SessionManager;
use Opera\Component\Http\Session\SessionManagerInterface;
use Opera\Component\Template\PhpEngine;
use Opera\Component\Template\RenderInterface;
use Opera\Component\Http\Middleware\MiddlewareCollectionInterface;

abstract class Context extends ApplicationContext
{

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @var RenderInterface
     */
    protected $render;


    public abstract function getControllerNamespace() : string;

    public abstract function getViewDirectory() : string;

    public abstract function getRouteCollection() : RouteCollection;

    /**
     * @param MiddlewareCollectionInterface $collection
     * @return MiddlewareCollectionInterface
     */
    public function getMiddlewareCollection(MiddlewareCollectionInterface $collection) : MiddlewareCollectionInterface
    {
          return $collection;
    }

    /**
     * @return RenderInterface
     */
    public function getTemplateEngine() : RenderInterface
    {
        if ($this->render === null) {
            $this->render = new PhpEngine($this->getViewDirectory());
        }

        return $this->render;
    }

    /**
     * @return SessionManagerInterface
     */
    public function getSessionManager() : SessionManagerInterface
    {
        if ($this->sessionManager === null) {
            $this->sessionManager = new SessionManager();
        }

        return $this->sessionManager;
    }

    /**
     * @return AuthenticationInterface|null
     */
    public function getAuthentication() : ?AuthenticationInterface
    {
        return null;
    }

    /**
     * @return AccessControlListInterface
     * @throws NotConfiguredException
     */
    public function getAccessControlList() : AccessControlListInterface
    {
        throw NotConfiguredException::component(AccessControlList::class);
    }
}
