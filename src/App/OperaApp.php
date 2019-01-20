<?php
/**
 * The Opera Framework
 * OperaApplication.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   22-11-18
 * @version   1.0
 */

namespace Opera\App;


use Opera\Component\Application\AbstractContainerApplication;
use Opera\Component\Application\CommandContainer;
use Opera\Component\Application\CommandInterface;
use Opera\App\Command\InstallCommand;

class OperaApp extends AbstractContainerApplication
{

    /**
     * Contains all the available commands
     * @return CommandContainer|CommandInterface[]
     */
    protected function commands(): CommandContainer
    {
        return (new CommandContainer())
            ->add(new InstallCommand());
    }

}