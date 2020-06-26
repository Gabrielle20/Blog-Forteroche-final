<?php

require_once "model/formModel.php";

Class Form{
	
	public $html;
	public $data;
	public $firstName;
	public $lastName;
	public $country;
	public $email;
	public $subject;
	public $message;
	


	function __construct($arguments)
	{
		$donnees = new formModel($arguments);
		if ($arguments["email"] != null){
			$this->mailSending($arguments);
			return;
		}

		$this->html = file_get_contents("./template/form.html");
	}


	private function mailSending($data){
		$this->lastName = $this->data["lastName"];
		$this->firstName = $this->data["firstName"];
		$this->country = $this->data["country"];
		$this->email = $this->data["email"];
		$this->subject = $this->data["subject"];
		$this->message = $this->data["content"];

		$headers = "From : " . $this->email;
		$txt = "Vous avez reçu un email de " . $this->lastName . $this->firstName . ".\n\n" . $this->message;


		ini_set("SMTP","ssl:smtp.gmail.com" ); // must be set to your own local ISP
		ini_set("smtp_port","465"); // assumes no authentication (passwords) required 
		ini_set( 'sendmail_from', $this->email); // can be any e-mail address, but must be set

		$to = 'gabriellecaeiro@gmail.com'; // the address that will receive the e-mail

		$headers = 'MIME-Version: 1.0' . PHP_EOL; // PHP_EOL automatically inserts \r or \n or \r\n as appropriate
		$headers .= 'Content-type: text/plain; charset=iso-8859-1' . PHP_EOL; // for HTML e-mail, use text/html
		$headers .= 'From: gabriellecaeiro@gmail.com'; // This instruction overrides sendmail_from above. IMPORTANT: do not include PHP_EOL here

		try{
			mail( $to, $this->subject, $this->message, $headers ); // sends the e-mail
			$this->html = "Votre message a bien été envoyé.";
		}

		catch(exception $e){
			die(var_dump($e));
		}




	}
}