<?php

require_once "./model/userModel.php";
require_once "./controller/SessionManager.php";

Class User{

	public $name = "Jean Forteroche";
	public $id = null;
	public $pseudo;
	public $email;
	public $prenom;
	public $data;
	public $html;
	public $session;



	function __construct()
  	{
  		//1.  on vérifie les informations en session
  		$this->session = new SessionManager();
  		if(empty($this->session->name)) $this->authByPostData();
  		else $this->authBySession();

  		//2. on vérifie les infos en post

	}


	private function authByPostData(){
		global $safeData;

		if ($safeData->post === null) return $this->session->end();
		if ($safeData->post["pseudo"] === null || $safeData->post["password"] === null) return $this->session->end();
		$data = new UserModel(["connect" => [
			"pseudo" => $safeData->post["pseudo"],
			"pwd" => $safeData->cryptString($safeData->post["password"])
		]]);
		$this->hydrate($data->data);
	}


	private function authBySession(){
		if(! isset($this->session->pseudo)) return;
		$this->pseudo =$this->session->pseudo;
		$this->email = $this->session->email;
		$this->name = $this->session->name;
		$this->prenom = $this->session->prenom;

	}	


	private function hydrate($data){
		if(!$data) return;
		foreach ($data as $key => $value){
			$this->$key = $value;
			$this->session->update($key, $value);
		}
	}


	public function logout(){
		$this->session->end();
	}

}