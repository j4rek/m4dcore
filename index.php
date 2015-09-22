<?php
include_once("core/instancer.php");

config::mostrarErrores(1);

//Rescatar y analizar los parametros para evitar SQLINY
$_GET = utility::checkVars($_GET);
$_path=isset($_GET["path"]) ? $_GET["path"]:"home";

core::set($_path);

core::render();
?>