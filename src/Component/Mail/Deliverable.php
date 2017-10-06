<?php
/**
 * Deliverable.php
 *
 * @package    Opera
 * @author     Marc Heuker of Hoek <me@marchoh.com>
 * @copyright  2016 - 2017 All rights reserved
 * @version    1.0
 * @since      1.0
 */

namespace Opera\Component\Mail;


use Opera\Component\Http\Header\Headers;

class Deliverable
{

    /**
     * @var \Opera\Component\Mail\MailMessage
     */
    protected $message;
    /**
     * @var \Opera\Component\Http\Header\Headers
     */
    protected $headers;

    public function __construct(MailMessage $message, Headers $headers)
    {

        $this->message = $message;
        $this->headers = $headers;
    }

}