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


use Opera\Component\Authentication\AuthenticationInterface;
use Opera\Component\Authorization\AccessControlList;
use Opera\Component\Authorization\AccessControlListInterface;
use Opera\Component\Database\DatabaseManager;
use Opera\Component\Database\DatabaseManagerInterface;
use Opera\Component\Http\Session\SessionManager;
use Opera\Component\Http\Session\SessionManagerInterface;
use Opera\Component\Template\PhpEngine;
use Opera\Component\Template\RenderInterface;
use Opera\Component\Http\Middleware\MiddlewareCollectionInterface;

abstract class Context
{
    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @var RenderInterface
     */
    protected $render;

    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->configuration = $configuration ?? new Configuration();
    }

    public function getEnvironment() : string
    {
        return $this->configuration->getSection('general')->getString('environment', 'production');
    }

    public abstract function getControllerNamespace() : string;

    public abstract function getViewDirectory() : string;

    public abstract function getRouteCollection() : RouteCollection;

    public function getMiddlewareCollection(MiddlewareCollectionInterface $collection) : MiddlewareCollectionInterface
    {
          return $collection;
    }

    public function getConfig() : ConfigurationInterface
    {
        return $this->configuration;
    }

    public function getTemplateEngine() : RenderInterface
    {
        if ($this->render === null) {
            $this->render = new PhpEngine($this->getViewDirectory());
        }

        return $this->render;
    }

    public function getSessionManager() : SessionManagerInterface
    {
        if ($this->sessionManager === null) {
            $this->sessionManager = new SessionManager();
        }

        return $this->sessionManager;
    }

    public function getDatabaseManager() : DatabaseManagerInterface
    {
        throw NotConfiguredException::component(DatabaseManager::class);
    }

    public function getAuthentication() : ?AuthenticationInterface
    {
        return null;
    }

    public function getAccessControlList() : AccessControlListInterface
    {
        throw NotConfiguredException::component(AccessControlList::class);
    }
}
