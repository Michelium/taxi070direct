<?php
if(isset($_POST['email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "boeking@taxi070direct.nl";
    $email_subject = "Contactformulier inzending";

    function died($error) {
        // your error code can go here
        echo "
Het spijt ons zeer, maar er zijn fouten gevonden met het formulier dat u heeft ingediend. ";
        echo "
Deze fouten verschijnen hieronder.<br /><br />";
        echo $error."<br /><br />";
        echo "
Ga terug en los deze fouten op.<br /><br />";
        die();
    }


    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['comments'])) {
        died('Het spijt ons, maar er is een probleem met het formulier dat u hebt ingediend.');
    }



    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['telephone']; // not required
    $comments = $_POST['comments']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'Het e-mailadres dat u hebt ingevoerd, lijkt niet geldig te zijn.<br />';
  }

    $string_exp = "/^[A-Za-z .'-]+$/";

  if(!preg_match($string_exp,$first_name)) {
    $error_message .= '
De door u ingevoerde voornaam lijkt niet geldig te zijn.<br />';
  }

  if(!preg_match($string_exp,$last_name)) {
    $error_message .= 'De achternaam die u hebt ingevoerd, lijkt niet geldig te zijn.<br />';
  }

  if(strlen($comments) < 2) {
    $error_message .= '
De ingevoerde opmerkingen lijken niet geldig te zijn.<br />';
  }

  if(strlen($error_message) > 0) {
    died($error_message);
  }

    $email_message = "Form details below.\n\n";


    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }



    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";

// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);
?>

<!-- include your own success html here -->

Bedankt dat je contact met ons hebt opgenomen.
We nemen snel contact met je op.

<?php

}
?>
