<?php
//Archivos basicos del core
include_once "config.php";
include_once "mensajes.php";
include_once "db.php";
include_once "template.php";
include_once "utility.php";
include_once "base/model.php";
include_once "base/controller.php";

/**
 * instancer class.
 */
class core {
	static $_db;
	static $_tpl;
	static $_msg;
	static $_cfg;
	static $_html;

	/**
	 * set function.
	 *
	 *
	 * @access public
	 * @static
	 * @param string $route
	 * @return el metodo del objeto instanciado
	 */
	public static function set($route) {
		//seteando el metodo a invocar y el controlador necesario
		$_set=explode("/", $route);
		$_modulo=$_set[0];
		$_metodo=$_set[1];

		//incluye el controlador en base al parametro path
		include_once config::controladores.$_modulo.".php";
		
		//si el metodo no existe, llamamos a view
		if (empty($_metodo)) {
			$_metodo="index";
		}

		//invoca el metodo para mostrar el contenido de cada seccion
		$_objeto=new $_modulo();
		$_objeto->$_metodo();
		
		//
	}

	/**
	 * render function.
	 *
	 * procesa la vista en base a la información parametrizada
	 * @access public
	 * @static
	 * @param mixed $opcion (default: null)
	 * @param mixed $variable (default: null)
	 * @param array $data (default: array())
	 * @param mixed $init (default: null)
	 * @return void
	 */
	public static function render($opcion=null, $variable=null, $data=array(), $init=null) {
		// instancia la clase de templates
		if (!self::$_tpl) {
			self::$_tpl = new Template(config::vistas); // instancia clase template

			self::$_tpl->set_file("header", "partials/header.html"); //setea el header
			self::$_tpl->set_file("footer", "partials/footer.html"); //setea el footer
		}

		// establece el dominio static para imagenes, js, css
		self::$_tpl->set_var("DOMSTATIC", config::DOMSTATIC);

		//gatilla la opcion seleccionada
		switch ($opcion) {
			case "vista": //setea la plantilla
				self::$_tpl->set_file("plantilla", $variable);
				break;
			case "block": // setea el block y parsea la vista
				if ($init==0) {
					self::$_tpl->set_block("plantilla", $variable, "_".$variable);
				}
				foreach ($data as $key => $value) {
					self::$_tpl->set_var($key, $value);
				}
				self::$_tpl->parse("_".$variable, $variable, true);
	
				break;
			case "var": //setea una variable en la plantilla
				$_valores=explode(":", $variable);
				self::$_tpl->set_var($_valores[0], $_valores[1]);
				break;
			case "vars": //setea el conjunto de variables en la plantilla
				self::$_tpl->set_var($variable);
				break;
			case "cerrar":
				self::$_tpl->cerrar("partial".$variable, $variable);
				break;
			default: //imprime la vista
				self::$_tpl->cerrar("header", "outheader"); //renderiza header
				self::$_tpl->cerrar(); //renderiza body
				self::$_tpl->cerrar("footer", "outfooter"); //renderiza footer
				break;
		}
	}

} //-- END CLASS --#
?>