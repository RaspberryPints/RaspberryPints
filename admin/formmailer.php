<?php

// $mail_to and $mail_from must be set.

$mail_to = 'support@raspberrypints.com'; // Who is the E-Mail going to?
$mail_from = 'bug@raspberrypints.com'; // Where does the E-Mail appear to be from?

// OPTIONAL SETTING
$redirect_url = 'thank_you.php'; // Example: http://domain.com/thankyou.html - must be a FULL URL.

############################
# DO NOT EDIT BELOW THIS #
############################

// Fail if _POST and _GET are empty. Nothing to process.
if(count($_POST) == 0 AND count($_GET) == 0):
echo 'This form handler does nothing if visited directly. You must submit form data to this script.';
exit;
endif;

// Fail if $mail_to or $mail_from are not set.
if(empty($mail_to) OR empty($mail_from)):
echo 'You must edit this script and set the appropriate values for $mail_to and $mail_from.';
exit;
endif;

// Set $fields to whichever method is being used.
$fields = (count($_POST) > 0 ) ? $_POST : $_GET;

$message_body = "Form Submission \n\n";

foreach ($fields as $field => $value):
switch(strtolower($field)):
case 'redirect':
$redirect = $value;
break;
case 'subject':
$subject = $value;
break;
endswitch;
if (strtolower($field) != 'redirect' AND strtolower($field) != 'submit' AND strtolower($field) != 'subject'):
$message_body .= strtoupper($field) . ": " . $value . "\r\n";
endif;
endforeach;

// Set the redirect URL from the form (if set). $host_url is a default action if $redirect isn't set
$redirect = (empty($redirect_url)) ? $redirect : $redirect_url;
$host_url = $_SERVER['HTTP_HOST'];

// Set the message subject based upon a subject field being set or not.

$message_subject = (!empty($subject)) ? $subject : 'Message from '.$_SERVER['HTTP_HOST'];

$headers = 'From: ' . $mail_from. "\r\n" .
'Reply-To: ' . $mail_from . "\r\n" .
'X-Mailer: PHP/' . phpversion();

// Remove potentially injected headers from the body

if (!mail($mail_to, $message_subject, $message_body, $headers)):
echo "Message Send Failed.";
endif;

if(empty($redirect)):
header("Location: http://{$host_url}");
else:
header("Location: {$redirect}");
endif;
?>