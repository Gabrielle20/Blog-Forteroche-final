<?php


class View{
	public $html;


	/**
	 * [__construct description]
	 * @param   Array  $data    soit un tableau associatif, soit tableau simple
	 * @param   String $template [description]
	 * @return  void
	 */
	
	public function __construct($data, $template){
	    switch (isset($data[0])) {
	      case true:
	        $this->html = $this->mergeSeveralWithTemplate($data, $template);
	        break;
	      
	      default:
	        $this->html = $this->mergeWithTemplate($data, $template);
	        break;
	   };
  }

    private function mergeWithTemplate($args, $template){
    	global $config;
    	$args['{{ path }}'] = $config['path'];
	    return str_replace(
	      array_keys($args),
	      $args,
	      file_get_contents("./template/$template.html")
	    );
	  }

	  private function mergeSeveralWithTemplate($data, $template){
	    $html = "";
	    foreach ($data as $value) {
	      $html .= "\n".$this->mergeWithTemplate($value, $template);
	    }
	    return $html;
	  }




	
}