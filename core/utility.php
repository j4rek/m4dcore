<?php
/**
 * utility class.
 */
class utility {
	
	//variables y constantes
	static $palabras = array("select", "update", "insert", "delete", "drop table", "drop database", "alter table", "alter database", "sleep (", "sleep(", "grant", "window.", "<script", "< script", "<iframe", "< iframe", "prompt(", "prompt (", "alert(", "alert (", "console.", "document.");

	/**
	 * dia function.
	 *
	 * @access public
	 * @static
	 * @param mixed $fecha
	 * @return nombre del dia en español
	 */
	public static function dia($fecha) {
		$nombre="";
		$dia=date("D", strtotime($fecha));

		switch (strtolower($dia)) {
		case "mon":$nombre="Lunes";break;
		case "tue":$nombre="Martes";break;
		case "wed":$nombre="Miercoles";break;
		case "thu":$nombre="Jueves";break;
		case "fri":$nombre="Viernes";break;
		case "sat":$nombre="Sabado";break;
		case "sun":$nombre="Domingo";break;
		}

		return $nombre;
	}

	/**
	 * mes function.
	 *
	 * @access public
	 * @static
	 * @param mixed $fecha
	 * @param string $op (default: "l")
	 * @return mes del año en español en formato corto o largo
	 */
	public static function mes($fecha, $op="l") {
		$nombre="";
		$mes=date("M", strtotime($fecha));

		switch (strtolower($mes)) {
		case "jan":$nombre=($op=="l")?"Enero":"Ene";break;
		case "feb":$nombre=($op=="l")?"Febrero":"Feb";break;
		case "mar":$nombre=($op=="l")?"Marzo":"Mar";break;
		case "apr":$nombre=($op=="l")?"Abril":"Abr";break;
		case "may":$nombre=($op=="l")?"Mayo":"May";break;
		case "jun":$nombre=($op=="l")?"Junio":"Jun";break;
		case "jul":$nombre=($op=="l")?"Julio":"Jul";break;
		case "aug":$nombre=($op=="l")?"Agosto":"Ago";break;
		case "sep":$nombre=($op=="l")?"Septiembre":"Sep";break;
		case "oct":$nombre=($op=="l")?"Octubre":"Oct";break;
		case "nov":$nombre=($op=="l")?"Noviembre":"Nov";break;
		case "dec":$nombre=($op=="l")?"Diciembre":"Dic";break;
		}

		return $nombre;
	}

	/**
	 * formatoFecha function.
	 *
	 * @access public
	 * @static
	 * @param mixed $datetime
	 * @param string $op (default: "f")
	 * @return una fecha formateada
	 */
	public static function formatoFecha($datetime, $op="f") {
		$val="";
		$d=date("d", strtotime($datetime));
		$_d=self::dia($datetime);

		$m=date("m", strtotime($datetime));
		$m_=self::mes($datetime);
		$mc=self::mes($datetime, "c");

		$a=date("Y", strtotime($datetime));
		$_a=date("y", strtotime($datetime));

		$h=date("H", strtotime($datetime));
		$_m=date("i", strtotime($datetime));

		switch ($op) {
		case "f":
			$val=$d."-".$m."-".$_a;
			break;
		case "F":
			$val=$d."-".$m."-".$a;
			break;
		case "Fh":
			$val=$d."-".$m."-".$a." ".$h.":".$_m;
			break;
		case "fh":
			$val=$d."-".$m."-".$_a." ".$h.":".$_m;
			break;
		case "Fl":
			$val=$_d." ".$d." de ".$m_." del ".$a;
			break;
		case "fl":
			$val=$d." ".$mc." del ".$a;
			break;
		}

		return $val;
	}

	/**
	 * mysql_clean_string function.
	 *
	 * limpia los valores que vengan en $variable, si encuentra alguna palabra reservada de sql o javascript, redirecciona al home
	 * @access public
	 * @static
	 * @param mixed $variable
	 * @return void
	 */
	public static function mysql_clean_string($variable) {
		$found=false;
		foreach (self::$palabras as $valor) {
			if (stripos($variable, $valor)!==false) {
				$found=true;
			}
		}
		if ($found==true) {
			if (config::debug) {
				mensajes::alerta("parametros no validos");
			}else {
				self::redirect();
			}
		}else {
			return $variable;
		}
	}

	/**
	 * redirect function.
	 *
	 * Redirecciona a la url $destino
	 * @access public
	 * @static
	 * @param string $destino (default: "")
	 * @return void
	 */
	public static function redirect($destino="") {
		if (self::is_empty($destino)) {
			header("location: ".config::URLBASE);
		}else {
			header("location: ".$destino);
		}

		exit();
	}

	/**
	 * is_empty function.
	 *
	 * Retorna true si el valor es vacio
	 * @access public
	 * @static
	 * @param mixed $value
	 * @return boolean
	 */
	public static function is_empty($value) {
		if (!isset($value) || is_null($value) || trim($value)=="") {
			return true;
		}else {
			return false;
		}
	}

	/**
	 * checkVars function.
	 * 
	 * Revisa cada variable para limpiar los parametros
	 * @access public
	 * @static
	 * @param mixed $data
	 * @return void
	 */
	public static function checkVars($data) {
		$db = new db();
		$arreglo=array();
		foreach ($data as $key =>$valor) {
			if (is_array($valor)) {
				foreach ($valor as $ind => $val) {
					$_tmp[$ind]=self::mysql_clean_string(mysql_real_escape_string($val));
				}
				$data[$key]=$_tmp;
				unset($_tmp);
			}else {
				$data[$key]=self::mysql_clean_string(mysql_real_escape_string($valor));
			}
		}
		$arreglo=$data;

		return $arreglo;
	}
	
	/**
	 * dump function.
	 * 
	 * ejecuta var_dump de una variable
	 * @access public
	 * @static
	 * @param mixed $var
	 * @return void
	 */
	public static function dump($var){
		echo "<pre>";
		var_dump($var);
		echo "</pre>";
	}
	
	/**
	 * genElementHtml function.
	 * 
	 * Genera un elemento html
	 *
	 * @access public
	 * @static
	 * @param mixed $elem
	 * @param array $props (default: array())
	 * @param mixed $inner (default: null)
	 * @return HTML del elemento solicitado
	 */
	public static function genElementHtml($elem,$props=array(),$inner=null){
		$_html="";
		$_propiedades="";
		
		//para utilizar tree
		if(stripos($elem, "ntree|")!==false){
			$elem_tmp=str_ireplace("ntree|", "", $elem);
			$elem = "ntree";
		}
		
		switch($elem){
			case "img":
				foreach($props as $key => $prop){
					$_propiedades.=$key."='$prop' ";
				}
				$_html="<img $_propiedades />";
				break;
				
			case "a":
				foreach($props as $key => $prop){
					$_propiedades.=$key."='$prop' ";
				}
				$_html="<a $_propiedades >".$inner."</a>";
				break;
			
			case "div":
				foreach($props as $key => $prop){
					$_propiedades.=$key."='$prop' ";
				}	
				$_html="<div $_propiedades >".$inner."</div>";
				break;
			case "tree":
				$_elementos=explode("|",$elem_tmp);
				$_elementos=array_reverse($_elementos);
				$props = array_reverse($props);
				self::dump($props);
				self::dump($_elementos);
				foreach($_elementos as $k => $elemento){
				
					$_child=explode("+",$elemento);
					if(count($_child)>1){	
						foreach($_child as $e => $htm){
							$_htmlchild.=self::genElementHtml($htm,$props[$k][$e]);
						}
					}else{
						$_html=self::genElementHtml($elemento,$props[$k],$_htmlchild);
					}

				}
				break;
			case "ntree":
				$_elementos = explode(">",$elem_tmp);
				self::dump($_elementos);
				$_elementos = array_reverse($_elementos);
				foreach($_elementos as $elemento => $val){
					$_elemento = explode(".",$val,2);
					$_e = $_elemento[0];
					$_clases = explode(".",$_elemento[1]);
					$_props=array("class" => implode(" ", $_clases));
					$_html=self::genElementHtml($_e,$_props,$_html);
				}
				
				break;
				
		}
		
		return $_html;
	}
}
?>