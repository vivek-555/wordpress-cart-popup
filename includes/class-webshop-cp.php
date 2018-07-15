<?php

if(!defined('ABSPATH'))
	return;


class Webshop_CP{

	protected static $instance = null;

	//Get instance
	public static function get_instance(){
		if(self::$instance === null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct(){

		//Front end
		include_once WEBSHOP_CP_PATH.'/includes/class-webshop-cp-public.php';
		Webshop_CP_Public::get_instance();

		//Core functions
		include_once WEBSHOP_CP_PATH.'/includes/class-webshop-cp-core.php';
		Webshop_CP_Core::get_instance();

	}

}

?>