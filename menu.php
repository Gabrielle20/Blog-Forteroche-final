<?php

require_once "model/menuModel.php";
require_once "view/menuView.php";

class Menu{
  public  $html;
  private $currentPage;
  private $model;
  private $view;

  public function __construct($type){

    global $safeData;
    $this->currentPage = implode("/", $safeData->uri);  //détermine l'adresse de la page actuelle
    $this->model       = new MenuModel();
    $this->view        = new MenuView();
    $this->html        = $this->$type();
  }

  public function __toString(){
    return $this->html;
  }

  private function getAllPages(){
    $pages    = $this->getPages(false);
    $episodes = $this->view->surroundTag("ul", $this->getEpisodes(false));
    $episodes = $this->view->surroundTag("li", $episodes);
    return $this->view->surroundTag("ul", $pages.$episodes);
  }

  private function getEpisodes($surround=true, $title=true){
    $pages = $this->model->getEpisodes();
    if (! $title){
      foreach ($pages as $key => $value){
        $pages[$key]['title'] = explode(":", $value['title'])[0];
      }
    }


    $html  = $this->view->makeMenuFromArray($pages, $this->currentPage, "episode/");
    if ($surround) $html = $this->view->surroundTag("ul", $html);
    return $html;
  }

  private function getPages($surround=true){
    $pages = $this->model->getPages();
    $html  = $this->view->makeMenuFromArray($pages, $this->currentPage);
    if ($surround) $html = $this->view->surroundTag("ul", $html);
    return $html;
  }


  private function getAllPageWithoutChapterTitle(){
    $pages    = $this->getPages(false);
    $episodes = $this->view->surroundTag("ul", $this->getEpisodes(false, false));
    $episodes = $this->view->makeScrollableMenu($episodes);
    $episodes = $this->view->surroundTag("li", $episodes);
    return $this->view->surroundTag("ul", $pages.$episodes);
  }


  private function getBackMenu($surround=true){
    $pages = $this->model->getBackMenu();
    $html = $this->view->makeMenuFromArray($pages, $this->currentPage);
    if ($surround) $html = $this->view->surroundTag("ul", $html);
    return $html;
  }


}