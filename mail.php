<?php

	$to      = 'abc@gmail.com';
	$subject = "Contact with us";


	$firstname = stripslashes($_POST['firstname']);
	$lastname = stripslashes($_POST['lastname']);
	$email = stripslashes($_POST['email']);
	$state = stripslashes($_POST['state']);
	$city = stripslashes($_POST['city']);
	$zip = stripslashes($_POST['zip']);
	$phone = stripslashes($_POST['phone']);
	$message = stripslashes($_POST['message']);

	$emailBody = "This form is submited from RedTail website.\r\n"
 	. "\r\n"
 	. "First Name : $firstname\r\n"
 	. "Last Name : $lastname\r\n"
 	. "City : $city\r\n"
 	. "State : $state\r\n"
 	. "Zip :$zip\r\n"
 	. "Email : $email\r\n"
 	. "Phone : $phone\r\n"
 	. "\r\n"
 	. "Message : $message\r\n"
 	. "";
	$headers = "Bcc: abc@gmail.com \r\n";
	$headers .= "From: $firstname" . " $lastname" . "<$email>\r\n" ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=ISO-8859-1" . "\r\n";

	$errorEmpty = false;
	$errorEmail = false;

	if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["email"]) || empty($_POST["state"]) || empty($_POST["city"]) || empty($_POST["zip"]) || empty($_POST["phone"]) || empty($_POST["message"])) {
    echo "<div class='alert alert-danger'>Please fill all fields.</div>";
     $errorEmpty = true;
    exit;
  	} 
  	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       echo "<div class='alert alert-danger'>Please ennter valid email</div>";
       $errorEmail = true;
       exit;
    	}


	$secret="Secret key";
	$response=$_POST['g-recaptcha-response'];

	$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
	$captcha_success=json_decode($verify);
	if ($captcha_success->success==true) {
	 mail($to, $subject, $emailBody, $headers);
	 echo "<div class='alert alert-success'>Form has been submited successfully</div>";
	 
	}
	else if ($captcha_success->success==false) {
	 echo "<div class='alert alert-danger'>validation fail</div>";
	 exit;
	}

?>

