<?php

require_once "model.php";

Class commentModel extends Model{

	function __construct($argument){
		parent::__construct();
		extract($argument);
		if (isset($lastComments)) return $this->getLastComments();
		if (isset($episode_id))	  return $this->getComment($episode_id);
		if (isset($editComment))  return $this->getCommentForEdit();
		if (isset($postComment))  return $this->postComment($postComment);
		if (isset ($reportComment)) return $this->reportComment($reportComment);
		if (isset($deleteComment))	return $this->deleteComment($deleteComment);
	}



	private function getLastComments(){
		$sql = "SELECT episodes.title AS '{{ episode_title }}', comments.author AS '{{ author }}', comments.date_time AS '{{ date }}', comments.content AS '{{ comment }}' FROM `comments` INNER JOIN episodes WHERE comments.episode_id = episodes.id ORDER BY comments.date_time DESC LIMIT 5";
		$this->query($sql, true);
	}


	private function getComment($episode_id){
		$sql = "SELECT author AS '{{ author }}', date_time AS '{{ date }}', content AS '{{ comment }}', id AS '{{ id }}' FROM `comments` WHERE `episode_id` = '$episode_id' ORDER BY date_time DESC ";
		$this->query($sql, true);
	}


	private function getCommentForEdit(){
		$sql = "SELECT id AS '{{ id }}', author AS '{{ author }}', content AS '{{ content }}', date_time AS '{{ date }}', episode_id AS '{{ episode_id }}', etat AS '{{ state }}' FROM comments WHERE etat = 1";
		$this->query($sql, true);
	}


	private function postComment($data){
		$sql = "INSERT INTO comments (author, date_time, content, episode_id, etat) VALUES (:author, NOW(), :content, :episode_id, 0)";
		$request = $this->bdd->prepare($sql);
    	$result = $request->execute([
	      'content'   	=>$data["comment"],
	      'episode_id'  => $data["id"],
	      'author'    	=> $data["commentAuthor"]
    	]);
	}


	private function reportComment($data){
		$sql = "UPDATE `comments` SET `etat` = '1' WHERE `comments`.`id` = :id";
		$request = $this->bdd->prepare($sql);
    	$result = $request->execute([
	      'id'  => $data["id"],
    	]);
	}


	private function deleteComment($data){
		$sql = "DELETE FROM `comments` WHERE `comments`.`id` = :id";
		$request = $this->bdd->prepare($sql);
		$result = $request->execute([
			'id' => $data["id"];
		])
	}
}