<?php

require_once "model/commentModel.php";
require_once "view/view.php";

Class Comment
{
	public $html;
	public $data;
	public $id = null;


	function __construct($arguments)
	{
		$donnees = new commentModel($arguments);
		if (isset($arguments["postComment"]) || isset($aguments["reportComment"]) || isset($arguments["deleteComment"])) return;
		$this->data = $donnees->data;
		$this->html = $this->generatehtml($arguments);
	}




	private function generatehtml($arguments){
		extract($arguments);
		if(isset($lastComments))
		{
			$view = new View($this->data, "lastComments");

			return $view->html;
		}

		if (isset($episode_id))
		{
			if (empty($this->data)) return file_get_contents("./template/messagePasDeCommentaire.html");
			$view = new View($this->data, "comments");

			return $view->html;
		}

		if (isset($editComment))
		{
			$view = new View($this->data, "edit-comment");

			return $view->html;
		}

	}


	

}