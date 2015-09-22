<?php
/*
	Modelo base para otros componentes
*/
class model{
	/**
	 * params
	 * 
	 * (default value: [])
	 * Filtros para la consulta SQL
	 * @var mixed
	 * @access public
	 */
	public $params = array();
	
	/**
	 * sorts
	 * 
	 * (default value: [])
	 * Sorts para la consulta SQL
	 * @var mixed
	 * @access public
	 */
	public $sorts  = array();
	
	/**
	 * QUERY
	 * 
	 * (default value: "")
	 * String que contiene la consulta SQL
	 * @var string
	 * @access protected
	 */
	protected $__query = "";
	
}	
?>