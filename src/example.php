<?php

require '../vendor/autoload.php';

use Abruno\PhpMailer\Models\Contact;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail            = new PHPMailer( true );

// SMTP settings
$host            = 'smtp.example.com';
$port            = 465;
$isSecure        = true;
$isAuth          = true;
$userName        = 'username';
$password        = 'password';

$attachments     = array();                                                             // Attachments

$subject         = 'subject';
$isHTML          = false;
$body            = <<< heredoc
Hello user,
this is the email message sent with the email..
Good bye!
heredoc;

$txt             = null;
$sender          = new Contact( 'Name', 'mail@example.com' );
$sender->replyTo = new Contact( 'Name', 'mail@example.com' );
$recipients      = array( new Contact( 'Name', 'mail@example.com' ) );
$ccs             = array( new Contact( 'Name', 'mail@example.com' ) );
$bccs            = [];

try {

	// Server settings

	$mail->SMTPDebug = SMTP::DEBUG_SERVER;                                              // Enable verbose debug output
	$mail->isSMTP();                                                                    // Send using SMTP
	$mail->Host       = $host;                                                          // Send using SMTP
	$mail->SMTPAuth   = $isAuth;                                                        // Enable SMTP authentication
	$mail->Username   = $userName;                                                      // Enable SMTP authentication
	$mail->Password   = $password;                                                      // SMTP password
	$mail->SMTPSecure = $isSecure ? PHPMailer::ENCRYPTION_SMTPS : null;                 // Enable implicit TLS encryption
	$mail->Port       = $port;

	// Sender

	$mail->setFrom( $sender->address, $sender->name );
	$mail->addReplyTo( $sender->replyTo->address, $sender->replyTo->name );

	// Recipients

	foreach ( $recipients as $recipient )                                               // Recipients
	{
		$mail->addAddress( $recipient->address, $recipient->name );
	}

	foreach ( $ccs as $cc )                                                             // CC Recipients
	{
		$mail->addCC( $cc->address, $cc->name );
	}

	foreach ( $bccs as $bcc )                                                           // Blind CC Recipients
	{
		$mail->addCC( $bcc );
	}


	// Attachments

	foreach ( $attachments as $attachment ) {
		$mail->addAttachment( $attachment );
	}

	// Content

	$mail->isHTML( $isHTML );
	$mail->Subject = $subject;
	$mail->Body    = $body;
	if ( ! is_null( $txt ) ) {
		$mail->AltBody = $txt;
	}

	// Send

	$mail->send();

	echo 'Message has been sent';

} catch ( Exception $e ) {

	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

}