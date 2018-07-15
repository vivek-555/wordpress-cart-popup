<?php
/**
* Plugin Name: WooCommerce cart in popup 
* Plugin URI: http://webshop.co
* Author: Webshop GmbH
* Version: 1.0
* Text Domain: woocommerce-cart-popup
* Domain Path: /languages
* Author URI: http://webshop.co
* Description: Open cart in a popup without refreshing page.
**/

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}

$webshop_cp_version = 1.0;

define("WEBSHOP_CP_PATH", plugin_dir_path(__FILE__));
define("WEBSHOP_CP_URL", plugins_url('',__FILE__));
define("WEBSHOP_CP_VERSION",1.3);


//Admin Settings
include_once WEBSHOP_CP_PATH.'/admin/webshop-cp-admin.php';

//Init plugin
function webshop_cp_rock_the_world(){
	global $webshop_cp_gl_atcem_value;
	
	//If mobile
	if(!$webshop_cp_gl_atcem_value){
		if(wp_is_mobile()){
			return;
		}
	}
	require_once WEBSHOP_CP_PATH.'/includes/class-webshop-cp.php';
	//Start the plugin
	Webshop_CP::get_instance();
}
add_action('plugins_loaded','webshop_cp_rock_the_world');
