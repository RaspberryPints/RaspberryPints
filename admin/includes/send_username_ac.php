<?
require_once dirname(__FILE__) . "/../../includes/config.php";

// value sent from form
$email_to=$_POST['email_tou'];


$username = $db->where('email', $email_to)->getValue('users', 'username');

if($username){

    $your_username=$username;

    // ---------------- SEND MAIL FORM ----------------

    // send e-mail to ...
    $to=$email_to;

    // Your subject
    $subject="Your username";

    // From
    $header="from: Support <shawn@besmartdesigns.com>";

    // Your message
    $messages.="This is your username to your login ( $your_username ) \r\n";

    // send email
    $sentmail = mail($to,$subject,$messages,$header);

} else {
    echo "Error ";
}

// if your email succesfully sent
echo "An email has been sent including the info you have requested.";?><a href="../index.php">Click Here<a/> to go back to the login.
