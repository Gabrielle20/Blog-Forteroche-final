<?php

require_once "controller/episode.php";
require_once "controller/comment.php";
require_once "controller/menu.php";
require_once "controller/from.php";

/**
 * 
 */
class Front
{

  public $html;

  /**
   * [__construct description]
   * @param Array $uri [description]
   */
  function __construct($uri)
  {
    switch($uri[0]){
      case "episode" : $this->afficheEpisode($uri[1]); break;
      case "contact" : $this->contact();break;
      case "a-propos": $this->about(); break;
      default        : $this->afficheAccueil(); break;
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



  private function afficheEpisode($slug){
    $ack = "";
    global $safeData;
    if ($safeData->post !== null){
      //Pour faire fonctionner le bouton "Envoyer" 
      if ($safeData->post ["EnvoyerCommentaire"] === "Envoyer"){
        new Comment(["postComment" => $safeData->post]);
      }


      //Pour faire fonctionner le bouton "Signaler" 
      if ($safeData->post ["EnvoyerCommentaire"] === "Signaler"){
        new Comment(["reportComment" => $safeData->post]);
        $ack = file_get_contents("./template/commentaireSignale.html");
      }
    }

    $monEpisode = new Episode(["slug"=>$slug]);
    $comments = new Comment(["episode_id"=>$monEpisode->data["id"]]);


    $viewAddComment = new View(
      ["{{ idPost }}" => $monEpisode->data["id"]],
      "formulaireAjoutCommentaire"
    );

    $view = new View (
      [
        "{{ episode }}"=>$monEpisode->html,
        "{{ commentaires }}"=>$comments->html,
        "{{ posterCommentaires }}"=>$viewAddComment->html,
        "{{ ack }}" => $ack
      ],
      "episode"
    );
  
    $this->title = $monEpisode->data['title'];
    $this->content = $view->html;

  }




  private function afficheAccueil(){
    $episodes = new Episode(["list"=>true]);
    $lastComments = new Comment(["lastComments" =>true]);
    
    $view = new View(
      [
        "{{ episodes }}" => $episodes->html,
        "{{ commentaires }}" => $lastComments->html
      ],
      "home"
    );

    $this->content = $view->html;
    $this->title = "Un Billet pour l'Alaska";
  }
  


  private function contact(){
    global $safeData;
    $form = new Form($safeData->post);


    $this->content = $form->html;
    $this->title = "Contact";


  }


  private function about(){
    $this->content = file_get_contents("./template/a-propos.html");
    $this->title = "À propos";
  }



}


