<?php

/**
 * 
 */
class Security
{
  
  public $uri;
  public $post;
  private $customRules = [
    "safeString" =>[
        'filter' => FILTER_SANITIZE_STRING,
        'flag'   => FILTER_FLAG_STRIP_LOW
      ]
  ];
  private $cryptogram ="";

  function __construct($argument)
  {
    if (isset($argument["post"])) $this->post = filter_input_array(INPUT_POST, $this->transcode($argument["post"]));
    if (isset($argument["uri"])) $this->sanityzeUrl($argument["uri"]);
    if (isset($argument["salt"])){
      $this->cryptogram .= $argument["salt"];
    }
  }


  private function sanityzeUrl($path){
    $this->uri = $_SERVER["REQUEST_URI"];
    
    $this->uri = urldecode($this->uri);
   

    if ($path !== ""){
      $this->uri = explode($path, $this->uri);
      $this->uri = implode("", $this->uri);
    }
    $this->uri = explode("/", $this->uri);
    $this->uri = array_slice($this->uri, 1);
  }



  /**
    * method that allows to use predefined combination for security check
    * @param Object $rules  rules defined in index.php
    * @return Object              rules rewritten
  **/

  private function transcode($rules){
    $tmp = [];
    foreach ($rules as $key => $value){
      if(isset($this->customRules[$value])) {
        $tmp[$key] = $this->customRules[$value];
      }

      else $tmp[$key] = $value;
    }

    return $tmp;
  }


  /**
    * allows to crypt a string
    * @param String $str clear string
    * @return String     encrypted string
  **/

  public function cryptString($str){
    return hash('sha256', $this->cryptogram.$str);
  }



}