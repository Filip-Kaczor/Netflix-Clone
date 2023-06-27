<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("phpmailer/src/PHPMailer.php");
require_once("phpmailer/src/SMTP.php");
require_once("phpmailer/src/Exception.php");

function sanitizeFormPassword($inputText) {
	$inputText = strip_tags($inputText);
	return $inputText;
}

function sanitizeFormUsername($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	return $inputText;
}

function sanitizeFormEmail($inputText) {
	$inputText = strip_tags($inputText);
	$inputText = str_replace(" ", "", $inputText);
	$inputText = strtolower($inputText);
	return $inputText;
}

function generateRandomString($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

if(isset($_POST['registerButton'])) {

	$username = sanitizeFormUsername($_POST['username']);
	$email = sanitizeFormEmail($_POST['email']);
	$email2 = sanitizeFormEmail($_POST['email2']);
	$password = sanitizeFormPassword($_POST['password']);
	$password2 = sanitizeFormPassword($_POST['password2']);

	if($register == "on") {
		$wasSuccessful = $account->register($username, $email, $email2, $password, $password2);
		if($wasSuccessful == true) {

			$_SESSION['userLoggedIn'] = $username;

			$mail = new PHPMailer(true);
			$sendEmail = new SendEmail($con, $mail);
	
			$secureCode = $functions->createSecureCode("activate", $username);
			$sendEmail->sendEmail("VERIFY", $username, $secureCode);
	
			$url = "/verify/".$username;
			header("Location: ".$indexUrl.$url);
		}

	}else {
		header("Location: ".$indexUrl);
	}

}


?>




