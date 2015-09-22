<?php
class home{
	public function __construct(){
		
	}
	
	public static function index(){
		core::render("vista","home.html");
		
	}
}