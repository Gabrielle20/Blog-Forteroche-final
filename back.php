<?php

require_once "controller/episode.php";
require_once "controller/comment.php";
require_once "controller/menu.php";
require_once "controller/user.php";

Class Back{

	public $html;


	public function __construct($uri){
		$this->user = new User();
		if ($this->user->pseudo === null) $this->login();
		else{
			if (count($uri) === 0){
				$uri = [""];
			}
			
			switch($uri[0]){
				case "edit-episode" 	: $this->editEpisode();break;
				case "edit-comment" 	: $this->editComment();break;
				case "edit-un-episode" 	: $this->editUnEpisode(); break;
				case "deconnexion"		: $this->logout(); break;
				default 				: $this->afficheBackAccueil(); break;
			}
		}
		

		$menu = new Menu("getAllPageWithoutChapterTitle");
    	$view = new View(
	      [
	        "{{ title }}" =>$this->title,
	        "{{ menu }}" =>$menu->html,
	        "{{ content }}" =>$this->content

	      ],

     		"main"
    	);

        $this->html .= $view->html;
	}


	private function login(){
		$this->content = file_get_contents("./template/authentification.html");
	    $this->title = "Se connecter";
	}


	public function afficheBackAccueil(){
		global $safeData;
		if ($safeData->post !== null){
			if ($safeData->post["title"] !== null){
				$data = $safeData->post;
				$data["author"] = $this->user->name;
				$data["slug"] = $this->makeSlug($data["title"]);
				$episodes = new Episode(["save"=>$data]);
			}
	     if ($safeData->post ["deleteComment"] === "Supprimer"){
	        new Comment(["deleteComment" => $safeData->post]);
	      }

	      if ($safeData->post["deleteEpisode"] === "Supprimer"){
	      	new Episode(["deleteEpisode" => $safeData->post]);
	      }
		}
		
		$episodes = new Episode(['new'=>true]);
		$edition = new Menu("getBackMenu");

		$view = new View(
			[
				"{{ newepisode }}" =>$episodes->html,
				"{{ edition }}" =>$edition->html,
				"{{ content }}"=> file_get_contents("./template/ajoute-episode.html")
			],
			"homeBack"
		);

		$this->content = $view->html;
	    $this->title = "Admin";
		}



	private function makeSlug($title){
		$title = strtolower($title);
		$title = str_replace(" ", "-", $title);
		$title = str_replace("é", "e", $title);
		return $title;
	}



	private function editEpisode(){
		global $safeData;
		if($safeData->post !== null){
			$data = $safeData->post;
			$data["submit"] = new Episode(['delete' => true]);
		}

		$episodes = new Episode(['edit'=>true]);
		$edition = new Menu("getBackMenu");

		$view = new View(
			[
				"{{ content }}"=>$episodes->html,
				"{{ edition }}"=>$edition->html
			],
			"homeBack"
		);

		$this->content = $view->html;
		$this->title = "Édition d'épisodes";
	}



	private function editComment(){
		$comment = new Comment(['editComment'=>true]);
		$edition = new Menu("getBackMenu");

		$view = new View(
			[
				"{{ content }}"=>$comment->html,
				"{{ edition }}"=>$edition->html
			],
			"homeBack"
		);

		$this->content = $view->html;
		$this->title = "Édition de commentaires";
	}


	private function editUnEpisode(){
		global $safeData;
		if($safeData->post !== null){
			$data = $safeData->post;
			$data["slug"] = $this->makeSlug($data["title"]);
			$episode = new Episode(['editUnEpisode' => $data]);
		}

		else{
			$episode = new Episode(['editUnEpisode' => true]);
		}

		$edition = new Menu("getBackMenu");
		$view = new View(
			[
				"{{ content }}" => $episode->html,
				"{{ edition }}" => $edition->html
			],
			"homeBack"
		);

		$this->content = $view->html;
		$this->title = "Édition d'un épisode" . $episode->data["title"];
	}



	private function logout(){
		global $config;
		$this->user->logout();
		$host = filter_input(INPUT_SERVER, "HTTP_HOST");
        header("Location: " . $config["path"] . "/admin/");

	}

}