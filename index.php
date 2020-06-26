<?php
require_once "controller/front.php";
require_once "controller/security.php";
require_once "controller/back.php";



$config = [
	"dbname" => "dbs527557",
	"user"     => "dbu909619",
  "password" => "LeMeux2001/GP",
  "path"     => "", //changer par le sous dossier où est rangé votre projet
  "debug"    => true,
  "host"  => "db5000549594.hosting-data.io"
];


if ($config["debug"]){
  error_reporting(E_ALL | E_STRICT);
  ini_set('display_errors',1);
}



$safeData = new Security(
  [
    "post" =>[
      "title"               => "safeString",
      "content"             => "safeString",
      "id"                  => FILTER_SANITIZE_NUMBER_INT,
      "submit"              => "safeString",
      "pseudo"              => "safeString",
      "password"            => "safeString",
      "last-name"           => "safeString",
      "first-name"          => "safeString",
      "country"             => "safeString",
      "email"               => "safeString",
      "subject"             => "safeString",
      "EnvoyerCommentaire"  => "safeString",
      "commentAuthor"       => "safeString",
      "comment"             => "safeString",
      "deleteComment"       => "safeString",
      "deleteEpisode"       => "safeString"
    ],
    "uri"   => $config["path"],
    "salt"  => "DSruw"
  ]
);


switch ($safeData->uri[0]) {
  case 'admin':
    $page = new Back(array_slice($safeData->uri, 1));
    break;
  
  default:
    $page = new Front($safeData->uri);
    break;
}


echo $page->html;


// /chapitre/nom-du-chapitre
// [
//   chapitre,
//   nom-du-chapitre
// ]

// /admin/edit-chapitre/5
// [
//   admin,
//   edit-chapitre,
//   5
// ]

// /liste-chapitres
// [
//   liste-chapitres
// ]