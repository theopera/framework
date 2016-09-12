<?php
/**
 * ParserInterface.php
 *
 * @package    Opera
 * @author     Marc Heuker of Hoek <me@marchoh.com>
 * @copyright  2016 - 2016 All rights reserved
 * @version    1.0
 * @since      1.0
 */

namespace Opera\Component\Template;


interface RenderInterface
{

    /**
     * Add a variable that will be globally accessible
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function addGlobal(string $key, $value);

    /**
     * Loads a template file into memory
     *
     * usually without extension, depending on selected render engine
     *
     * @param string $file
     *
     * @return mixed
     */
    public function loadFile(string $file);

    /**
     * Parses the given template file with the given data
     *
     * @param string[] $data
     *
     * @return string
     */
    public function render(array $data = []) : string;
}