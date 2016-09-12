<?php
/**
 * MailMessage.php
 *
 * @package    Opera
 * @author     Marc Heuker of Hoek <me@marchoh.com>
 * @copyright  2016 - 2016 All rights reserved
 * @version    1.0
 * @since      1.0
 */

namespace Opera\Component\Mail;


use SplFileObject;

class MailMessage
{

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var SplFileObject[]
     */
    protected $attachments = [];

    /**
     * @return string
     */
    public function getFrom() : string
    {
        return $this->from;
    }

    /**
     * @param string $email
     * @param string $name
     */
    public function setFrom(string $email, string $name)
    {
        $this->from = sprintf('%s <%s>', $name, $email);

        return $this;
    }

    /**
     * @return string
     */
    public function getTo() : string
    {
        return $this->to;
    }

    /**
     * @param string $email
     * @param string $name
     */
    public function setTo(string $email, string $name)
    {
        $this->to = sprintf('%s <%s>', $name, $email);

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return SplFileObject[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param SplFileObject[] $attachments
     */
    public function addAttachment(SplFileObject $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }


    public function __toString() : string
    {
        return sprintf('From: %s, To: %s, Subject: %s', $this->from, $this->to, $this->subject);
    }

}