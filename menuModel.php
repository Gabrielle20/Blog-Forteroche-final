<?php

require_once "model/model.php";

/**
 * 
 */
class MenuModel extends Model
{

  function __construct()
  {
    parent::__construct();
  }

  public function getEpisodes()
  {
    $sql = "SELECT title, slug FROM `episodes` ORDER BY id";
    $this->query($sql, true);
    return $this->data;
  }


  public function getPages()
  {
    $sql = "SELECT `title`, `slug` FROM `pages`";
    $this->query($sql, true);
    return $this->data;
  }


  public function getBackMenu()
  {
    $sql = "SELECT `title`, `slug` FROM `backMenu`";
    $this->query($sql, true);
    return $this->data;
  }
}