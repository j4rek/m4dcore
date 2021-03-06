<?php
date_default_timezone_set("America/Santiago");

class config {

	//# -- Constantes para conexion MySql -- ##
	const myHost="";
	const myDbase="";
	const myUser="";
	const myPass="";
	
	//# -- Constantes para conexion msSql -- ##
	const msHost="";
	const msDbase="";
	const msUser="";
	const msPass="";

	//# -- Constantes para envio de correo -- ##
	const SMTP_SERVER="mail.zoomchile.com";
	const SMTP_PORT="25";
	const SMTP_USER="envios@zoomchile.com";
	const SMTP_PASS="zoom2012";

	//# -- Constantes URLS del sitio -- ##
	const URLBASE="http://localhost/cgames/comunitygames";
	const DOMADMIN="http://panel.delosurales.com/";
	const DOMSTATIC="http://localhost/cgames/comunitygames/static/";
	//const DOMSTATIC="http://static.delosurales.com/";

	//# -- Constantes RUTAS de carpetas -- ##
	const repoFonts="fonts/";
	const repoPlantillas="views/";
	const repo="repo/";
	const repoUbic="/home/Zoom/sites/www/";
	const repoImagenesCachorros="camadas/";
	const repoImagenesPromesas="promesas/";
	const repoImagenesReproductores="reproductores/";
	const repoImagenesExposiciones="expos/";
	const repoImagenesNoticias="noticias/";
	const log="/home/Zoom/sites/www/lib/logs/";
	const controladores="/Library/WebServer/Documents/cgames/comunitygames/controller/";
	const vistas="/Library/WebServer/Documents/cgames/comunitygames/view/";
	const modelos="/Library/WebServer/Documents/cgames/comunitygames/model/";

	//# -- Caracteristicas para imagenes -- ##
	const anchoMax=800; //PIXELES
	const altoMax=600; //PIXELES
	const calidad=60; //PIXELES
	const thAncho=80; //PIXELES
	const thAlto=50; //PIXELES
	public $fpermitidos=array("jpg", "jpeg", "gif", "png");

	//# -- CODIGOS DE ERRORES -- ##

	//# -- Plataforma desarrollo o producción -- ##
	const debug=true; // true = desarrollo - false = produccion

	function __construct() {}

	//#------------------------##
	public static function mostrarErrores($bool=self::debug) {
		error_reporting(E_ALL ^ E_NOTICE ^E_DEPRECATED);
		ini_set("display_errors", $bool);
	}
}
?>
