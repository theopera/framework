<?php
/**
 * TemplateEngine.php
 *
 * @package    Opera
 * @author     Marc Heuker of Hoek <me@marchoh.com>
 * @copyright  2016 - 2016 All rights reserved
 * @version    1.0
 * @since      1.0
 */

namespace Opera\Component\Template;


class PhpEngine implements RenderInterface
{

    /**
     * Contains the template file
     *
     * @var string
     */
    private $contents;

    /**
     * Contains variables that will be passed to the template
     *
     * @var string[]
     */
    private $variables = [];

    /**
     * @var string
     */
    private $basePath;

    public function __construct(string $basePath = '.')
    {
        $this->basePath = $basePath;
    }

    public function addGlobal(string $key, $value)
    {
        $this->variables[$key] = $value;
    }


    /**
     * Loads a template file into memory
     *
     * @param string $file
     *
     * @return mixed
     */
    public function loadFile(string $file)
    {
        $path = $this->basePath . '/' . $file . '.phtml';
        if (!is_readable($path)) {
            throw new TemplateException(sprintf('Template engine could not read the file "%s"', $path));
        };

        if (($this->contents = file_get_contents($path)) === false) {
            throw new TemplateException(sprintf('File "%s" not readable', $path));
        }

    }

    public function render(array $data = []) : string
    {
        return $this->renderFile($data + $this->variables);
    }

    /**
     * This method keeps it possible to use $data as template variable
     *
     * @param array $__data
     */
    private function renderFile(array $__data = []) : string
    {
        ob_start();

        extract($__data, EXTR_REFS & EXTR_SKIP);
        eval('?>' . $this->contents);

        return ob_get_clean();
    }


}