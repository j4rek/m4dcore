<?php
/**
 * controller class base para los controladores de la aplicacion.
 */
class controller{
	/**
	 * model
	 * Representa el modelo asociado al controlador para la extraccion de datos
	 * @var mixed
	 * @access protected
	 */
	protected $model;
	
	public function __construct(){
		//incluye el modelo en base al parametro path
		include_once config::modelos.get_class($this).".php";
		
		//crea el modelo asociado a la seccion
		$_moduloModel = get_class($this)."Model";
		$this->model= new $_moduloModel();	
	}
}	
?>