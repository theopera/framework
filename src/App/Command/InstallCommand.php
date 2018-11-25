<?php
/**
 * The Opera Framework
 * InstallerCommand.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2018 - 2018 All rights reserved
 * @license   MIT
 * @created   22-11-18
 * @version   1.0
 */

namespace Opera\App\Command;


use Exception;
use Opera\Component\Application\Color;
use Opera\Component\Application\CommandInfo;
use Opera\Component\Application\CommandInterface;
use Opera\Component\Application\Io\InInterface;
use Opera\Component\Application\Io\OutInterface;
use Opera\Component\ErrorHandler\Exception\ErrorException;
use SplFileInfo;
use stdClass;

class InstallCommand implements CommandInterface
{

    const PROJECT_ROOT = '.';

    private $namespace = 'Opera\\Sample';

    private $projectName = 'Opera Sample Project';

    /**
     * @var CommandInfo
     */
    protected $info;

    /**
     * InstallerCommand constructor.
     */
    public function __construct()
    {
        $this->info = (new CommandInfo())
        ->setName('install')
        ->setDescription('Installs The Opera Framework in the current working directory');
    }


    /**
     * Get info about the command
     *
     * @return CommandInfo
     */
    public function getInfo(): CommandInfo
    {
       return $this->info;
    }

    /**
     * @param InInterface $in
     * @param OutInterface $out
     * @param OutInterface|null $err
     * @return int
     * @throws Exception
     */
    public function run(InInterface $in, OutInterface $out, OutInterface $err = null): int
    {
        $out->write($this->getHeader());

        if ($this->isAlreadyInstalled()) {
            $err->writeln(PHP_EOL . 'It looks like that the framework is already installed!');
            return 1;
        }

        // Run through the questions
        $this->questions($out, $in);

        // Create project directory structure
        $this->createStructure();

        // Copy the project files with the configured options injected
        $this->copyFiles();

        // Update the composer file (add the namespace to the autoloader)
        $this->modifyComposerFile();


        $out->writeln(PHP_EOL . 'The installation is complete');
        $out->writeln(PHP_EOL . '!! Please run "composer update" to make the new namespace autoloadable !!');
    }


    /**
     * Finds out if the framework has already been installed
     *
     * @return bool
     */
    private function isAlreadyInstalled() : bool
    {
        $public = new SplFileInfo(self::PROJECT_ROOT  . '/public');
        $src = new SplFileInfo(self::PROJECT_ROOT  . '/src');

        return $public->isDir() && $src->isDir();
    }

    /**
     * @throws Exception
     */
    private function createStructure()
    {
        $directories = [
            'src',
            'src/Controller',
            'src/view',
            'src/view/controller',
            'src/view/controller/default',
            'public',
            'public/asset',
            'public/asset/script',
            'public/asset/style',
            'public/asset/image',
        ];

        foreach ($directories as $directory) {
            try{
                mkdir(self::PROJECT_ROOT . '/' . $directory);
            }catch (ErrorException $e) {
                if ($e->getSeverity() !== 2) {
                    throw new Exception('Creating directory structure failed');
                }
            }
        }
    }

    private function copyFiles()
    {
        $files = [
            'DefaultController.txt' => 'src/Controller/DefaultController.php',
            'MyContext.txt' => 'src/MyContext.php',
            'MyController.txt' => 'src/MyController.php',
            'MyContainer.txt' => 'src/MyContainer.php',
            'index.txt' => 'public/index.php',
            'index.phtml' => 'src/view/controller/default/index.phtml',
            'config.ini' => 'config.ini',
        ];

        foreach ($files as $source => $destination) {
            $content = file_get_contents(__DIR__ . '/resource/installer/' . $source);

            $content = str_replace([
                '__APP_NAME__',
                '__NAMESPACE__',
                '__NAMESPACE_DOUBLE__',
            ], [
                $this->projectName,
                $this->namespace,
                addslashes($this->namespace),
            ], $content);

            file_put_contents(self::PROJECT_ROOT . '/' . $destination, $content);
        }
    }

    private function questions(OutInterface $out, InInterface $in)
    {
        $out->writeColor('What will be the name of your project: ', Color::LIGHT_GRAY);
        $this->projectName = trim($in->read(128));

        $out->writeColor('The namespace where the project will live in: ', Color::LIGHT_GRAY);
        $this->namespace = trim($in->read(128));

        $out->write(PHP_EOL . 'That is all we need so far.');
    }

    /**
     * Modifies the composer file
     * - Add the new project namespace to the autoload list
     */
    private function modifyComposerFile()
    {
        if (!is_writeable('composer.json')) {
            throw new Exception('Make sure a composer.json file exists and is writable');
        }

        $json = file_get_contents('composer.json');
        $composer = json_decode($json);

        if (!isset($composer->autoload) || !isset($composer->autoload->{'psr-4'})) {
            $composer->autoload = new stdClass();
            $composer->autoload->{'psr-4'} = new stdClass();
        }

        // Composer namespaces requires an extra slash at the end
        $namespace = $this->namespace . '\\';
        $composer->autoload->{'psr-4'}->{$namespace} = 'src';

        file_put_contents('composer.json', json_encode($composer, JSON_PRETTY_PRINT));
    }

    private function getHeader() : string
    {
        return '
  _____ _             ___                         _____                                            _    
 |_   _| |__   ___   / _ \ _ __   ___ _ __ __ _  |  ___| __ __ _ _ __ ___   _____      _____  _ __| | __
   | | | \'_ \ / _ \ | | | | \'_ \ / _ \ \'__/ _` | | |_ | \'__/ _` | \'_ ` _ \ / _ \ \ /\ / / _ \| \'__| |/ /
   | | | | | |  __/ | |_| | |_) |  __/ | | (_| | |  _|| | | (_| | | | | | |  __/\ V  V / (_) | |  |   < 
   |_| |_| |_|\___|  \___/| .__/ \___|_|  \__,_| |_|  |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
                          |_|                                                                           
                          
Welcome, this installer will guide you though the installation of The Opera Framework
';
    }
}