<?php
class mensajes {

	const format_alerta      ="<div style='margin-top:1px;z-index:200000;position:relative;background-color:#fdea60;font-size:14px;color:black;font-family:arial;padding:5px;border-radius:4px;'>{msg}</div>";
	const format_confirmar   ="<div style='margin-top:1px;z-index:200000;position:relative;background-color:#aac34e;font-size:14px;color:white;font-family:arial;padding:5px;border-radius:4px;'>{msg}</div>";
	const format_error_script="<div style='margin-top:1px;z-index:200000;position:relative;background-color:#ca1212;font-size:14px;color:white;font-family:arial;padding:5px;border-radius:4px;'>{msg}</div>";
	const format_error_db    ="<div style='margin-top:1px;z-index:200000;position:relative;background-color:#0085b0;font-size:14px;color:white;font-family:arial;padding:5px;border-radius:4px;'>{msg}</div>";
	const format_estandar    ="<div style='margin-top:1px;z-index:200000;position:relative;background-color:#e28903;font-size:14px;color:white;font-family:arial;padding:5px;border-radius:4px;'>{msg}</div>";



	/**
	 * _errores
	 *
	 * Array de errores numerados.
	 * @var mixed
	 * @access public
	 * @static
	 */
	static public $_errores=array( "e100"=>"Error query: <br/>",
		"e101"=>"Error al momento de seleccionar la Base de Datos! <br />",
		"e102"=>"Error en la conexion con el Servidor! <br />",
		"e103"=>"Error al momento de cerrar la conexion con el Servidor! <br />",
		"e104"=>"Error en parametro!.<br />");

	/**
	 * alerta function.
	 *
	 * Imprime $mensaje en el formato de alerta
	 * @access public
	 * @static
	 * @param string $mensaje (default: "")
	 * @param string $adicional (default: "")
	 * @return void
	 */
	public static function alerta($mensaje="", $adicional="") {
		if ($mensaje) {
			if (is_numeric($mensaje)) {
				$mensaje="e".$mensaje;
				echo str_replace("{msg}", self::$_errores[$mensaje]." ".$adicional, self::format_alerta);
			}else {
				echo str_replace("{msg}", $mensaje, self::format_alerta);
			}
		}
	}

	/**
	 * confirmar function.
	 *
	 * Imprime $mensaje en formato de confirmacion
	 * @access public
	 * @static
	 * @param string $mensaje (default: "")
	 * @param string $adicional (default: "")
	 * @return void
	 */
	public static function confirmar($mensaje="", $adicional="") {
		if ($mensaje) {
			if (is_numeric($mensaje)) {
				$mensaje="e".$mensaje;
				echo str_replace("{msg}", self::$_errores[$mensaje]." ".$adicional, self::format_confirmar);
			}
			else {
				echo str_replace("{msg}", $mensaje, self::format_confirmar);
			}
		}
	}

	/**
	 * error_script function.
	 *
	 * @access public
	 * @static
	 * @param string $mensaje (default: "")
	 * @param string $adicional (default: "")
	 * @return void
	 */
	public static function error_script($mensaje="", $adicional="") {
		if ($mensaje) {
			if (is_numeric($mensaje)) {
				$mensaje="e".$mensaje;
				echo str_replace("{msg}", self::$_errores[$mensaje]." ".$adicional, self::format_error_script);
			}else {
				echo str_replace("{msg}", $mensaje, self::format_error_script);
			}
		}
	}

	/**
	 * error_db function.
	 *
	 * Imprime el mensaje con formato de error de BD
	 * @access public
	 * @static
	 * @param string $mensaje (default: "")
	 * @param string $adicional (default: "")
	 * @return void
	 */
	public static function error_db($mensaje="", $adicional="") {
		if ($mensaje) {
			if (is_numeric($mensaje)) {
				$mensaje="e".$mensaje;
				echo str_replace("{msg}", self::$_errores[$mensaje]." ".$adicional, self::format_error_db);
			}else {
				echo str_replace("{msg}", $mensaje." ".$adicional, self::format_error_db);
			}
		}
	}

	/**
	 * msg function.
	 *
	 * Imprime $mensaje en formato estandar
	 * @access public
	 * @static
	 * @param string $mensaje (default: "")
	 * @return void
	 */
	public static function msg($mensaje="") {
		if ($mensaje) {
			echo str_replace("{msg}", $mensaje, self::format_estandar);
		}
		else {
			self::alerta("Error en parametro");
		}
	}

}
?>