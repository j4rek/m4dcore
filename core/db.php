<?php
class db {

	var $conexion=null;

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param string $tipoDb (default: "mysql")
	 * @return void
	 */
	function __construct($tipoDb="mysql") {
		switch ($tipoDb) {
		case "mysql":
			$conexion=self::myConectar();
			break;
		case "mssql":
			$conexion=self::msConectar();
			break;
		}
	}

	/**
	 * myConectar function.
	 * 
	 * Establece la conexion a BD mysql
	 * @access public
	 * @static
	 * @return void
	 */
	static function myConectar() {
		$resultado = NULL;
		try{
			if ($con = mysql_connect(config::myHost, config::myUser, config::myPass)) {
				if (mysql_select_db(config::myDbase, $con)) {
					mysql_set_charset('utf8',$con);
					return $con;
				}else {
					mensajes::error_db(101);
				}
			}else {
				mensajes::error_db(102);
			}
		}catch(\Exception $e) {
			echo "Error: ".$e->getMessage()."";
		}
	}

	/**
	 * myDesconectar function.
	 * 
	 * Elimina la conexion a la BD mysql
	 * @access public
	 * @static
	 * @return void
	 */
	static function myDesconectar() {
		$resultado = NULL;
		try{
			if (!mysql_close($conexion)) {
				mensajes::error_db(103);
			}
		}catch(\Exception $e) {
			echo "Error: ".$e->getMessage()."";
		}
	}

	/**
	 * myQuery function.
	 * 
	 * Ejecuta la query(mysql)
	 *
	 * @access public
	 * @static
	 * @param mixed $sqlstr
	 * @param int $mostrar (default: 0), Imprime la consulta final
	 * @return un objeto con los valores retornados, el total de filas
	 */
	static function myQuery($sqlstr, $mostrar=0) {
		$obj=new stdClass();
		$obj->rows=array();
		$obj->count=0;
		
		//Si no existe conexion, genera una.
		if ($conexion==null) {
			$conexion=self::myConectar();
		}
		
		//ejecuta la consulta sql
		$res = mysql_query($sqlstr, $conexion);
		
		//imprime la consulta por pantalla
		if ($mostrar==1) {
			echo mensajes::msg($sqlstr, true);
		}

		if (!$res) {//si no hay respuesta o error en la ejecucion
			if (config::debug) { // si el debug esta activo
				$_arr=debug_backtrace(); // imprime la consulta mas el error
				die(mensajes::error_db(100, $sqlstr."<br>".mysql_error()."<br><br>Arc:".$_arr[0]["file"]."<br>linea:".$_arr[0]["line"]));
			}else { // si el debug esta inactivo, redirecciona a la pagina principal
				header("location: ".config::URLBASE);
				exit();
			}
		}else { // si hay respuesta
			$i=0;
			$obj->count=mysql_num_rows($res);
			while ($row=mysql_fetch_array($res)) {
				if ($i==($obj->count-1)) {
					$key="LAST";
				}else {
					$key=$i;
				}
				array_push($obj->rows, ($row));
				$i++;
			}
		}

		return $obj;
	}

	/**
	 * msConectar function.
	 * 
	 * Establece la conexion a BD SQLServer
	 * @access public
	 * @static
	 * @return void
	 */
	static function msConectar() {
		$resultado = NULL;
		try{
			if ($con = mssql_connect(config::msHost, config::msUser, config::msPass)) {
				if (mysql_select_db(config::msDbase, $con)) {
					return $con;
				}else {
					mensajes::error_db(101);
				}
			}else {
				mensajes::error_db(102);
			}
		}catch(Exception $e) {
			echo "Error: ".$e->getMessage()."";
		}
	}

	/**
	 * msDesconectar function.
	 * 
	 * Elimina la conexion a BD SQLServer
	 * @access private
	 * @return void
	 */
	private function msDesconectar() {
		$resultado = NULL;
		try{
			if (!@mssql_close($conexion)) {
				mensajes::error_db(103);
			}
		}catch(Exception $e) {
			echo "Error: ".$e->getMessage()."";
		}
	}

	/**
	 * msQuery function.
	 * 
	 * Ejecuta la query(SQLServer)
	 * @access public
	 * @static
	 * @param mixed $sqlstr
	 * @param int $mostrar (default: 0), imprime la consulta final
	 * @return void
	 */
	static function msQuery($sqlstr, $mostrar=0) {

		if ($conexion==null) {
			$conexion=self::msConectar();
		}

		$res = mssql_query($sqlstr, $conexion);
		if ($mostrar==1)
			echo mensajes::msg($sqlstr);

		if (!$res) {
			if (config::debug) {
				die(mensajes::error_db(100, $sqlstr."<br>".mysql_error()));
			}
			else {
				header("location: ./");
				exit();
			}
		}
		return $res;
		//$this->cerrar_conexion($conx);

	}
	
	/**
	 * buildQuery function.
	 * Construye la consulta sql, añadiendo parametros y sorts
	 * @access public
	 * @static
	 * @param mixed $_sql (string: requerido con la consulta base)
	 * @param array $_params (default: array())
	 * @param array $_sorts (default: array())
	 * @return void
	 */
	static function buildQuery($_sql,$_params=array(),$_sorts=array()){
		//Agrega cada parametro a las condiciones de la query
		if(count($_params)>0){
			$_sql .= " where ";
			foreach($_params as $param => $val){
				$_sql .= $param . "='" . $val . "' and ";
			}
			
			//Quita el AND final despues de aplicar cada parametro.
			$_sql = substr($_sql, 0, -4);
		}
		
		//Agrega los sorts seteados para la query
		if(count($_sorts)>0){
			foreach($_sorts as $sort => $value){
				$_sorts .= $sort . " " . $value;
			}	
		}
		return $_sql .= ";";
	}

}
?>