<?php
/**
 * The Opera Framework
 * Message.php
 *
 * @author Marc Heuker of Hoek <me@marchoh.com>
 * @copyright 2016 - 2017 All rights reserved
 * @license MIT
 * @created 5/21/16
 * @version 1.0
 */

namespace Opera\Component\WebApplication;

class Message
{

    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $message;

    /**
     * Message constructor.
     *
     * @param string $type
     * @param string $title
     * @param string $message
     */
    public function __construct($type, $message, $title = null)
    {
        $this->type = $type;
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

}