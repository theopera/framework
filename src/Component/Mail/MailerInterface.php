<?php
/**
 * MailerInterface.php
 *
 * @package    Opera
 * @author     Marc Heuker of Hoek <me@marchoh.com>
 * @copyright  2016 - 2017 All rights reserved
 * @version    1.0
 * @since      1.0
 */

namespace Opera\Component\Mail;


use Opera\Component\Http\Header\Headers;

interface MailerInterface
{

    /**
     * Sends the mail to the mail server
     *
     * @param MailMessage $message The message to send
     * @param string[]    $headers Key value array with headers
     *
     * @throws MailException
     *
     * @return
     */
    public function send(MailMessage $message, Headers $headers);
}