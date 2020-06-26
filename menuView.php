<?php

class MenuView {

  public function __construct(){
  }

    public function surroundTag($tag, $data){
    return "<$tag>$data</$tag>";
  }

  public function makeMenuFromArray($data, $currentPage, $path=null){

    $html = "";
    for ($i=0; $i <count($data) ; $i++) {
      if ($path !== null) $data[$i]["slug"] = $path.$data[$i]["slug"];
      if ($data[$i]["slug"] !== $currentPage) $html .= $this->makeLiWithLink($data[$i]);
      else $html .= $this->makeLi($data[$i]);
    }
    return $html;
  }

  private function makeLiWithLink($data){
    global $config;

    return '<li><a href="'.$config["path"].'/'.$data["slug"].'">'.$data["title"].'</a></li>';
  }

  private function makeLi($data){
    return '<li class="active">'.$data["title"].'</li>';    
  }

  public function makeScrollableMenu($menu){
    return '<div class="scrollable" onclick="showHideMenu(this)">liste des épisodes'.$menu."</div>";
  }


}