<?php
/**
 * The Opera Framework
 * Context.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   22-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


use Opera\Component\Database\DatabaseManager;
use Opera\Component\Database\DatabaseManagerInterface;
use Opera\Component\WebApplication\Configuration;
use Opera\Component\WebApplication\ConfigurationInterface;
use Opera\Component\WebApplication\NotConfiguredException;
use Opera\Component\ErrorHandler\ErrorCatcher;

class Context
{
    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @var ErrorCatcher
     */
    protected $errorCatcher;

    /**
     * Context constructor.
     * @param ConfigurationInterface|null $configuration
     */
    public function __construct(ConfigurationInterface $configuration = null)
    {
        $this->configuration = $configuration ?? new Configuration();
    }

    /**
     * @return ConfigurationInterface
     */
    public function getConfig() : ConfigurationInterface
    {
        return $this->configuration;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->configuration->getSection('general')->getString('environment', 'production');
    }

    /**
     * Whenever this application is running in *production* mode
     * @return bool
     */
    public function isProduction(): bool
    {
        return $this->getEnvironment() === 'production';
    }

    /**
     * Whenever this application is running in *development* mode
     * @return bool
     */
    public function isDevelopment(): bool
    {
        return !$this->isProduction();
    }

    public function getErrorCatcher()
    {
        if ($this->errorCatcher === null) {
            $this->errorCatcher = new ErrorCatcher();
        }

        return $this->errorCatcher;
    }

    /**
     * @return DatabaseManagerInterface
     * @throws NotConfiguredException
     */
    public function getDatabaseManager(): DatabaseManagerInterface
    {
        throw NotConfiguredException::component(DatabaseManager::class);
    }

}