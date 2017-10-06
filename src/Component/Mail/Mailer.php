<?php
/**
 * Mail.php
 *
 * @package    Opera
 * @author     Marc Heuker of Hoek <me@marchoh.com>
 * @copyright  2016 - 2017 All rights reserved
 * @version    1.0
 * @since      1.0
 */

namespace Opera\Component\Mail;


use Opera\Component\Http\Header\Header;
use Opera\Component\Http\Header\Headers;
use Opera\Component\Http\Mime;
use SplFileObject;

class Mailer
{

    /**
     * @var \Opera\Component\Mail\MailerInterface
     */
    private $mailer;


    /**
     * @param \Opera\Component\Mail\MailerInterface $mailer
     * @param bool                                   $useHtml
     */
    public function __construct(MailerInterface $mailer = null, bool $useHtml = true)
    {
        $this->mailer = $mailer ?? new BasicMailer();
        $this->headers = new Headers();

        if ($useHtml) {
            $this->headers->add(new Header('Content-Type', Mime::TEXT_HTML));
        }else {
            $this->headers->add(new Header('Content-Type', Mime::TEXT_PLAIN));
        }
    }

    /**
     * Tries to deliver the mail
     *
     * @param \Opera\Component\Mail\MailMessage $message
     *
     * @throws MailException
     */
    public function send(MailMessage $message)
    {
        $this->headers->add(new Header('From', $message->getFrom()));

        $this->mailer->send($message, $this->headers);
    }

    /**
     * This will return a message body with the attachments in
     * basecode64 encoding also the original message will be included
     *
     * @param SplFileObject[] $files
     * @param string          $message
     * @param string          $contentType
     * @param string          $hash
     *
     * @return string
     */
    private function parseAttachments(array $files, string $message, string $contentType, string $hash) : string
    {
        $result = [];

        // The original message
        $result[] = '--body-mixed-' . $hash;
        $result[] = new Header('Content-Type', $contentType);
        $result[] = '';
        $result[] = $message;

        // The attachments
        foreach ($files as $file) {

            $headers = new Headers();
            $headers->add(new Header('Content-Transfer-Encoding', 'base64'));
            $headers->add(new Header('Content-Disposition', 'attachment'));
            $headers->add(new Header('Content-Type', 'application/octet-stream', [
                'filename' => $file->getFilename()
            ]));

            $result[] = '--body-mixed-' . $hash;
            $result[] = $headers;
            $result[] = '';
            $result[] = base64_encode($file->fread($file->getSize()));
        }

        return implode("\r\n", $result);
    }
}