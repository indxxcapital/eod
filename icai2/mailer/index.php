<?php

function sendmail($to, $subject, $body) 
{
	include_once "lib/swift_required.php";

	/*
	 * Create the body of the message (a plain-text and an HTML version).
	 * $text is your plain-text email
	 * $html is your html version of the email
	 * If the reciever is able to view html emails then only the html
	 * email will be displayed
	 */
	$text = "Hi!\nHow are you?\n";
	$html = $body;
	// This is your From email address
	$from = array ('indexing@indxx.com' => 'Indexing');

	// Email recipients
	$to = array ($to);

	// Email subject
	$subject = $subject;
	
	// Login credentials
	$username = 'azure_dd71e19f09f4753c305d62f15bdc6b27@azure.com';
	$password = 'OnDcD2jco18M0s8';
	
	// Setup Swift mailer parameters
	$transport = Swift_SmtpTransport::newInstance ( 'smtp.sendgrid.net', 587 );
	$transport->setUsername ( $username );
	$transport->setPassword ( $password );
	$swift = Swift_Mailer::newInstance ( $transport );
	
	// Create a message (subject)
	$message = new Swift_Message ( $subject );
	
	// attach the body of the email
	$message->setFrom ( $from );
	$message->setBody ( $html, 'text/html' );
	$message->setTo ( $to );
	$message->addPart ( $text, 'text/plain' );
	
	// send message
	if (!($recipients = $swift->send ( $message, $failures ))) 
	{
		echo "CRITICAL: Unable to send email!";
		//print_r ( $failures );
	}
}
?>