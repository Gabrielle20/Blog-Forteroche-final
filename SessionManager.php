<?php



class SessionManager{



	public function __construct(){
		session_start();
		foreach ($_SESSION as $key => $value){
			$this->$key = $value;
		}

	}

	public function update($key, $value){
		$this->$key = $value;
		$_SESSION[$key] = $value;
	}

	public function end(){
		session_unset();
	}
}