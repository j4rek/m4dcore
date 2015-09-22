<?php
class noticiasModel extends model{
	/**
	 * listado function.
	 * Entrega el listado completo de los registros almacenados del modelo
	 * @access protected
	 * @return void
	 */
	function listado(){
		$this->__query = "select * from " . str_replace("Model","",get_class($this));
		
		$this->__query = db::buildQuery($this->__query,$this->params,$this->sorts);

		return db::myQuery($this->__query);
	}
	
	/**
	 * dataFicha function.
	 * Entrega los datos unitarios de cada noticia
	 * @access public
	 * @return void
	 */
	function dataFicha(){
		$this->__query = db::buildQuery("select * from noticias ",$this->params,$this->sorts);
		
		return db::myQuery($this->__query,0,1);
	}
}	
?>