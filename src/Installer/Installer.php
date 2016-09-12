<?php
/**
 * The Opera Framework
 * Installer.php
 *
 * @author    Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2016 All rights reserved
 * @license   MIT
 * @created   8-7-16
 * @version   1.0
 */

namespace Opera\Installer;


use ErrorException;
use Exception;
use Opera\Component\Application\Application;
use SplFileInfo;
use stdClass;

/**
 * Class Installer
 * @package Opera\Installer
 */
class Installer extends Application
{
    
    const PROJECT_ROOT = '.';
    
    private $namespace = 'Opera\\Sample';
    
    private $projectName = 'Opera Sample Project';
    

    /**
     * Installer constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $this->getOut()->fwrite($this->getHeader());

        if ($this->isAlreadyInstalled()) {
            $this->getErr()->fwrite(PHP_EOL . 'It looks like that the framework is already installed!' . PHP_EOL);
            return;
        }


        // Run through the questions
        $this->questions();
        
        // Create project directory structure
        $this->createStructure();
        
        // Copy the project files with the configured options injected
        $this->copyFiles();
        
        // Update the composer file (add the namespace to the autoloader)
        $this->modifyComposerFile();


        $this->getOut()->fwrite(PHP_EOL . 'The installation is complete' . PHP_EOL);
        $this->getOut()->fwrite(PHP_EOL . '!! Please run "composer update" to make the new namespace autoloadable !!' . PHP_EOL);
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
            $content = file_get_contents(__DIR__ . '/resource/' . $source);
            
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

    private function questions()
    {
        $out = $this->getOut();
        $in = $this->getIn();

        $out->fwrite('What will be the name of your project: ');
        $this->projectName = trim($in->fgets());

        $out->fwrite('The namespace where the project will live in: ');
        $this->namespace = trim($in->fgets());

        $out->fwrite(PHP_EOL . 'That is all we need so far.');
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