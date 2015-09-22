<?php
class noticias extends controller{
	public function __construct(){
		parent::__construct(); // solo si requiere modelo asociado
	}
	
	public function index(){
		instancer::render("vista","noticias.html");
		
		if(isset($_GET["s"]) && !empty($_GET["s"])){
			$this->model->params["idSitio"] = $_GET["s"];
		}
		
		$data = $this->model->listado()->rows;
		foreach($data as $key => $value){
			 $dataNoticias=$value;
             instancer::render("block", "noticias", $dataNoticias, $key);
		}
	}
	
	public function ficha(){
		instancer::render("vista",get_class($this)."/ficha.html");
		
		if(!isset($_GET["ID"]) || empty($_GET["ID"])){
			utility::redirect();
		}else{
			$this->model->params["idNoticia"] = $_GET["ID"];
			$this->model->sorts["limit"] = 1;
		}
		$data = $this->model->dataFicha()->rows;
		
		instancer::render("vars",$data[0]);
	}
}