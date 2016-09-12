Opera Mail
=========

This is the mail component whitch allows you to send email.

Usage
----------

First you need to write a message with the `MailMessage` class

```php
<?php
	$message = (new MailMessage())
		->setFrom('johndoe@example.com', 'John Doe')
		->setTo('alice@example.com', 'Alice')
		->setSubject('This is a simple test mail')
		->setBody('This test mail can use <b>html<b/>');

	// Create a new mail instance with BasicMailer (which uses the php mail function)
	$mail = new Mailer();
	
	// Pass the message to the send method and it will take care of sending the mail
	$mail->send($message);
```

It is also possible to send a e-mail with attachments.
Which goes likes this.

```php
<?php
	$message = (new MailMessage())
		->setFrom('johndoe@example.com', 'John Doe')
		->setTo('alice@example.com', 'Alice')
		->setSubject('This is a simple test mail')
		->setBody('This test mail can use <b>html<b/>');

	// Create a new mail instance with BasicMailer (which uses the php mail function)
	$mail = new Mailer();
	
	// Pass the message to the send function and it will take care of sending the mail
	$mail->send($message);
```