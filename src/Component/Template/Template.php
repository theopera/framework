<?php
/**
 * Template.php
 *
 * @package    Opera
 * @author     Marc Heuker of Hoek <me@marchoh.com>
 * @copyright  2016 - 2017 All rights reserved
 * @version    1.0
 * @since      1.0
 */

namespace Opera\Component\Template;


class Template
{

    /**
     * @var RenderInterface
     */
    private $render;

    private $data = [];

    public function __construct(RenderInterface $render)
    {

        $this->render = $render;
    }

    public function load(string $file)
    {
        $this->render->loadFile($file);
    }

    public function assign(string $name, $value, bool $override = true)
    {

        if (!$override && isset($this->data[$name])) {
            return;
        }

        $this->data[$name] = $value;
    }

    /**
     * Returns the par
     *
     * @param array $data
     *
     * @return string
     */
    public function render(array $data = []) : string
    {
        return $this->render->render($this->data + $data);
    }

}