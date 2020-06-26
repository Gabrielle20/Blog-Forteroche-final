<?php 



class Model 
{

	protected $bdd;
  public $data;
  


	public function __construct()
	{
    try{
      global $config;
      $this->bdd = new PDO(
        'mysql:host='. $config["host"] .';dbname=' .$config["dbname"].';charset=utf8',
        $config["user"],
        $config["password"]

      );

      $this->bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
      $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    catch(exception $e){
      die($e);
    }
   
	}

  protected function query($sql, $all=false)
  {
    $reponse = $this->bdd->query($sql);
      if ($all) $this->data = $reponse->fetchAll();
      else $this->data = $reponse->fetch();

  }
}

