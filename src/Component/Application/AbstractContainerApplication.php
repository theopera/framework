<?php
/**
 * The Opera Framework
 * CommandContainerApplication.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   18-11-18
 * @version   1.0
 */

namespace Opera\Component\Application;


use Opera\Component\Application\Io\InInterface;
use Opera\Component\Application\Io\OutInterface;
use SplFileObject;

abstract class AbstractContainerApplication extends Application
{
    /**
     * @param ArgumentBag $argumentBag
     * @param InInterface $in
     * @param OutInterface $out
     * @param OutInterface|null $err
     * @return int
     */
    public function run(ArgumentBag $argumentBag, InInterface $in, OutInterface $out, OutInterface $err = null): int
    {
        // When no arguments were provided show the default help message
        if ($argumentBag->count() <= 1) {
            $this->help($out);
            return 1;
        }else{
            $commandName = $argumentBag->get(1);
            $commands = $this->commands();
            $command = $commands->get($commandName);

            if ($command === null) {
                $err->writeColorln('Command not found', Color::RED);
                return 2;
            }

            if ($argumentBag->count() === 3 && $argumentBag->get(2) === 'help') {
                $this->helpCommand($out, $command->getInfo());
                return 1;
            }

            return $command->run($argumentBag, $in, $out, $err);
        }
    }

    /**
     * Contains all the available commands
     * @return CommandContainer|CommandInterface[]
     */
    protected abstract function commands(): CommandContainer;

    /**
     * @param SplFileObject $out
     */
    protected function help(OutInterface $out)
    {
        foreach ($this->commands() as $command) {
            $info = $command->getInfo();

            $out->writeColorln($info->getName(), Color::GREEN);
            $out->writeln("\t" . $info->getDescription());
        }
    }

    protected function helpCommand(OutInterface $out, CommandInfo $info)
    {
        $out->writeColorln($info->getName(), Color::GREEN);
        $out->writeln("\t" . $info->getDescription());
        $out->writeln();
        $out->writeln("Example");
        $out->writeln($info->getExample());
        $out->writeln();

        $out->writeln("Options");
        foreach ($info->getOptions() as $parameter => $description) {
            $out->writeln(sprintf('    %-16s %s', $parameter, $description));
        }
    }

}