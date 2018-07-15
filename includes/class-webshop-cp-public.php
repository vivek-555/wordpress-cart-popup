<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}

class Webshop_CP_Public{

	protected static $instance = null;

	public function __construct(){
		add_action('wp_enqueue_scripts',array($this,'enqueue_scripts'));
		add_action('plugins_loaded',array($this,'load_txt_domain'),99);
		add_action('wp_footer',array($this,'get_popup_markup'));
	}

	//Get class instance
	public static function get_instance(){
		if(self::$instance === null){
			self::$instance = new self();
		}	
		return self::$instance; 
	}

	//Inline styles from cart popup settings
	public static function get_inline_styles(){
		global $webshop_cp_sy_pw_value,$webshop_cp_sy_imgw_value,$webshop_cp_sy_btnbg_value,$webshop_cp_sy_btnc_value,$webshop_cp_sy_btns_value,$webshop_cp_sy_btnbr_value,$webshop_cp_sy_tbc_value,$webshop_cp_sy_tbs_value,$webshop_cp_gl_ibtne_value,$webshop_cp_gl_vcbtne_value,$webshop_cp_gl_chbtne_value,$webshop_cp_gl_qtyen_value,$webshop_cp_gl_spinen_value;

		$style = '';

		if(!$webshop_cp_gl_vcbtne_value){
			$style .= 'a.webshop-cp-btn-vc{
				display: none;
			}';
		}

		if(!$webshop_cp_gl_ibtne_value){
			$style .= 'span.xcp-chng{
				display: none;
			}';
		}

		if(!$webshop_cp_gl_chbtne_value){
			$style .= 'a.webshop-cp-btn-ch{
				display: none;
			}';
		}

		if($webshop_cp_gl_qtyen_value && $webshop_cp_gl_ibtne_value){
			$style .= 'td.webshop-cp-pqty{
			    min-width: 120px;
			}';
		}
		else{
			
		}

		if(!$webshop_cp_gl_spinen_value){
			$style .= '.webshop-cp-adding,.webshop-cp-added{display:none!important}';
		}

		$style.= "
			.webshop-cp-container{
				max-width: {$webshop_cp_sy_pw_value}px;
			}
			.xcp-btn{
				background-color: {$webshop_cp_sy_btnbg_value};
				color: {$webshop_cp_sy_btnc_value};
				font-size: {$webshop_cp_sy_btns_value}px;
				border-radius: {$webshop_cp_sy_btnbr_value}px;
				border: 1px solid {$webshop_cp_sy_btnbg_value};
			}
			.xcp-btn:hover{
				color: {$webshop_cp_sy_btnc_value};
			}
			td.webshop-cp-pimg{
				width: {$webshop_cp_sy_imgw_value}%;
			}
			table.webshop-cp-pdetails , table.webshop-cp-pdetails tr{
				border: 0!important;
			}
			table.webshop-cp-pdetails td{
				border-style: solid;
				border-width: {$webshop_cp_sy_tbs_value}px;
				border-color: {$webshop_cp_sy_tbc_value};
			}";

			return $style;
	}


	//enqueue stylesheets & scripts
	public function enqueue_scripts(){
		global $webshop_cp_gl_resetbtn_value;

		wp_enqueue_style('webshop-cp-style',WEBSHOP_CP_URL.'/assets/css/webshop-cp-style.css',null,WEBSHOP_CP_VERSION);
		wp_enqueue_script('webshop-cp-js',WEBSHOP_CP_URL.'/assets/js/webshop-cp-js.min.js',array('jquery'),WEBSHOP_CP_VERSION,true);

		wp_localize_script('webshop-cp-js','webshop_cp_localize',array(
			'adminurl'     		=> admin_url().'admin-ajax.php',
			'homeurl' 			=> get_bloginfo('url'),
			'wc_ajax_url' 		=> WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'reset_cart'		=> $webshop_cp_gl_resetbtn_value
		));

		wp_add_inline_style('webshop-cp-style',self::get_inline_styles());

	}

	//Load text domain
	public function load_txt_domain(){
		$domain = 'added-to-cart-popup-woocommerce';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR . '/'.$domain.'-' . $locale . '.mo' ); //wp-content languages
		load_plugin_textdomain( $domain, FALSE, basename(WEBSHOP_CP_PATH) . '/languages/' ); // Plugin Languages
	}


	//Get popup markup
	public function get_popup_markup(){
		if(is_cart() || is_checkout()){return;}
		wc_get_template('webshop-cp-popup-template.php','','',WEBSHOP_CP_PATH.'/templates/');
	}


}

?>