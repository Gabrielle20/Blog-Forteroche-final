<?php


Class formModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}	


	public function contact(){
		$sql = "INSERT INTO contact (last-name, first-name, country, email, subject, message) VALUES (:last-name, :first-name, :country, :email, :subject, :message)";

	    $request = $this->bdd->prepare($sql);
	    $result = $request->execute([
	      'last-name'     => $data["last-name"],
	      'first-name'    => $data["first-name"],
	      'country'   	  => $data["country"],
	      'email'      => $data["email"],
	      'subject'   => $data["subject"],
	      'message'   => $data["message"]
	    ]);
	}	
}