<?php

require_once "model/episodeModel.php";
require_once "view/view.php";

/**
 * 
 */
class Episode
{

  public $html;
  public $data;
  public $id = null;



  /**
   * [__construct description]
   * @param Array $uri [description]
   */
  function __construct($arguments)
  {
    $donnees = new EpisodeModel($arguments);
    if (isset($arguments["deleteEpisode"])) return;
    $this->data = $donnees->data;
    
    $this->html = $this->generatehtml($arguments);
    // $this->data = $this->data->donneesRead;
    // if (!isset($this->data[0])) {
    //   foreach ($this->data as $key => $value) {
    //     $this[$key] = $value;
    //   }
    //   $this->data = null;
    // }
    
  }


  private function generatehtml($arguments){
    if(isset($arguments['list']))
    {
      $view = new View($this->data, "listEpisode");

      return $view->html;
    }




    if (isset($arguments['slug']))
    {
      $view = new View($this->data, "episodeSeul");
      
      return $view->html;

    }





    if (isset($arguments['new']))
    {
      $view = new View($this->data, "newEpisode");

      return $view->html;
    }





    if (isset($arguments['edit']))
    {
      for($i = 0; $i < count($this->data); $i++){
        $this->data[$i]["{{ episode_slug }}"] = "edit-un-episode/" . $this->data[$i]["{{ episode_slug }}"];
      }

      $view = new View($this->data, "edit-episode");

      return $view->html;

    }




    if (isset($arguments['editUnEpisode']))
    {
      if($arguments['editUnEpisode'] !== true){
        global $config;
        $host = filter_input(INPUT_SERVER, "HTTP_HOST");
        header("Location:http://" . $host . $config["path"] . "/admin/edit-un-episode/" . urlencode(strtolower($arguments['editUnEpisode']["slug"])));
      }

      global $safeData;
      if ($safeData->post !== null){
        if ($safeData->post["submit"] === "Mise à jour") {
          $donnees = new EpisodeModel(["editUnEpisode" => $safeData->post]);
        }
      }

      $donnees = new EpisodeModel(["slug"=>end($safeData->uri)]);
      $this->data = $donnees->data;
      $view = new View([
        '{{ id }}'            => $this->data["{{ id }}"],
        '{{ title }}'         => $this->data["{{ title }}"],
        '{{ content }}'       => $this->data["{{ content }}"],
      ], "edit-un-episode");

      return $view->html;
    }





    // if (isset($arguments["delete"]))
    // {
    //   global $safeData;
    //   if ($safeData->post !== null){
    //     if ($safeData->post["submit"] === "Supprimer") {
    //       $donnees = new EpisodeModel("deleteEpisode");
    //     }
    //   }

    //   $view = new View($this->data, "edit-episode");

    //   return $view->html;
    // }
  }
}