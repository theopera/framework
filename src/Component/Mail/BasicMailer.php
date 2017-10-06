<?php
/**
 * BasicMailer.php
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


class BasicMailer implements MailerInterface{

	/**
	 * @inheritdoc
	 */
	public function send(MailMessage $message, Headers $headers){

		$body = $message->getBody();

		if (!mail($message->getTo(), $message->getSubject(), $body, $headers)) {
			throw new MailException(sprintf('Mail could not be delivered to "%s"', $message->getTo()));
		}

	}



}