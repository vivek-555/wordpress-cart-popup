<?php
/**
 ========================
      ADMIN SETTINGS
 ========================
 */

//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}

// Enqueue Scripts & Stylesheet
function webshop_cp_admin_enqueue($hook){

	if('toplevel_page_webshop_cp' != $hook){
		return;
	}
	wp_enqueue_style('webshop-cp-admin-css',WEBSHOP_CP_URL.'/admin/assets/css/webshop-cp-admin-css.css',null,WEBSHOP_CP_VERSION);
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('webshop-cp-admin-js',WEBSHOP_CP_URL.'/admin/assets/js/webshop-cp-admin-js.js',array('jquery','wp-color-picker'),WEBSHOP_CP_VERSION,true);
}
add_action('admin_enqueue_scripts','webshop_cp_admin_enqueue');

//Settings page
function webshop_cp_menu_settings(){
	add_menu_page( 'Woocommerce cart popup', 'Woocommerce cart popup', 'manage_options', 'webshop_cp', 'webshop_cp_settings_cb', 'dashicons-cart', 61 );
	add_action('admin_init','webshop_cp_settings');
}
add_action('admin_menu','webshop_cp_menu_settings');

//Settings callback function
function webshop_cp_settings_cb(){
	include plugin_dir_path(__FILE__).'webshop-cp-settings.php';
}

//Custom settings
function webshop_cp_settings(){

	//General options
 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-atcem'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-pden'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-ibtne'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-qtyen'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-vcbtne'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-chbtne'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-spinen'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-gl-resetbtn'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-pw'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-imgw'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-btnc'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-btnbg'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-btns'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-btnbr'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-tbs'
 	);

 	register_setting(
		'webshop-cp-group',
	 	'webshop-cp-sy-tbc'
 	);

 	/** Settings Section **/

	add_settings_section(
		'webshop-cp-gl',
		'',
		'webshop_cp_gl_cb',
		'webshop_cp'
	);

	add_settings_section(
		'webshop-cp-sy',
		'',
		'webshop_cp_sy_cb',
		'webshop_cp'
	);

	add_settings_section(
		'webshop-cp-begad',
		'',
		'webshop_cp_begad_cb',
		'webshop_cp'
	);

	add_settings_section(
		'webshop-cp-endad',
		'',
		'webshop_cp_endad_cb',
		'webshop_cp'
	);


	add_settings_field(
		'webshop-cp-gl-atcem',
		'Enable on Mobile',
		'webshop_cp_gl_atcem_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-gl-pden',
		'Show product details',
		'webshop_cp_gl_pden_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-gl-ibtne',
		'+/- Qty Button',
		'webshop_cp_gl_ibtne_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-gl-qtyen',
		'Update Quantity',
		'webshop_cp_gl_qtyen_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-gl-vcbtne',
		'View Cart Button',
		'webshop_cp_gl_vcbtne_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-gl-chbtne',
		'Checkout Button',
		'webshop_cp_gl_chbtne_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-gl-spinen',
		'Show spinner icon',
		'webshop_cp_gl_spinen_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-gl-resetbtn',
		'Reset cart form',
		'webshop_cp_gl_resetbtn_cb',
		'webshop_cp',
		'webshop-cp-gl'
	);

	add_settings_field(
		'webshop-cp-sy-pw',
		'PopUp Width',
		'webshop_cp_sy_pw_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

	add_settings_field(
		'webshop-cp-sy-imgw',
		'Image Width',
		'webshop_cp_sy_imgw_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

	add_settings_field(
		'webshop-cp-sy-btnbg',
		'Button Background Color',
		'webshop_cp_sy_btnbg_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

	add_settings_field(
		'webshop-cp-sy-btnc',
		'Button Text Color',
		'webshop_cp_sy_btnc_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

	add_settings_field(
		'webshop-cp-sy-btns',
		'Button Font Size',
		'webshop_cp_sy_btns_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

	add_settings_field(
		'webshop-cp-sy-btnbr',
		'Button Border Radius',
		'webshop_cp_sy_btnbr_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

	add_settings_field(
		'webshop-cp-sy-tbs',
		'Item Border Size',
		'webshop_cp_sy_tbs_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

	add_settings_field(
		'webshop-cp-sy-tbc',
		'Item Border Color',
		'webshop_cp_sy_tbc_cb',
		'webshop_cp',
		'webshop-cp-sy'
	);

}

//Settings Section Callback
function webshop_cp_gl_cb(){
	?>
	<?php 	/** Settings Tab **/ ?>
	<div class="webshop-tabs">
		<!-- <ul>
			<li class="tab-1 active-tab">Main</li>
			<li class="tab-2">Advanced</li>
		</ul> -->
	</div>

<?php 	/** Settings Tab **/ ?>

	<?php
	$tab = '<div class="main-settings settings-tab settings-tab-active" tab-class ="tab-1">';  //Begin Main settings
	echo $tab;
	echo '<h2>General Options</h2>';
}

function webshop_cp_sy_cb(){
	echo '<h2>Style Options</h2>';
}

function webshop_cp_begad_cb(){
	$tab  = '</div>'; // End Main Settings
	$tab .= '<div class="advanced-settings settings-tab" tab-class ="tab-2">';
	echo $tab;
}

function webshop_cp_endad_cb(){
	ob_start();
	include(plugin_dir_path(__FILE__).'/webshop-cp-fvsp-template.php');
	$html  = ob_get_clean();
	$html .= '</div>'; // End Advanced settings
	echo $html;
}

//General Options Callback

//Enable on Mobile Devices
$webshop_cp_gl_atcem_value = sanitize_text_field(get_option('webshop-cp-gl-atcem','true'));
function webshop_cp_gl_atcem_cb(){
	global $webshop_cp_gl_atcem_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-atcem" id="webshop-cp-gl-atcem" value="true"'.checked('true',$webshop_cp_gl_atcem_value,false).'>';
	$html .= '<label for="webshop-cp-gl-atcem">Enable on mobile devices.</label>';
	echo $html;
}

//Show product details
$webshop_cp_gl_pden_value = sanitize_text_field(get_option('webshop-cp-gl-pden','true'));
function webshop_cp_gl_pden_cb(){
	global $webshop_cp_gl_pden_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-pden" id="webshop-cp-gl-pden" value="true"'.checked('true',$webshop_cp_gl_pden_value,false).'>';
	$html .= '<label for="webshop-cp-gl-pden"> Show product name/image/quantity.</label>';
	echo $html;
}

//Enable +/- button
$webshop_cp_gl_ibtne_value = sanitize_text_field(get_option('webshop-cp-gl-ibtne','true'));
function webshop_cp_gl_ibtne_cb(){
	global $webshop_cp_gl_ibtne_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-ibtne" id="webshop-cp-gl-ibtne" value="true"'.checked('true',$webshop_cp_gl_ibtne_value,false).'>';
	$html .= '<label for="webshop-cp-gl-ibtne"> Enable Increase/Decrease Quantity buttons.</label>';
	echo $html;
}

//Allow Quantity Update
$webshop_cp_gl_qtyen_value = sanitize_text_field(get_option('webshop-cp-gl-qtyen','true'));
function webshop_cp_gl_qtyen_cb(){
	global $webshop_cp_gl_qtyen_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-qtyen" id="webshop-cp-gl-qtyen" value="true"'.checked('true',$webshop_cp_gl_qtyen_value,false).'>';
	$html .= '<label for="webshop-cp-gl-qtyen">Allow users to update quantity from popup.</label>';
	echo $html;
}


//View Cart button
$webshop_cp_gl_vcbtne_value = sanitize_text_field(get_option('webshop-cp-gl-vcbtne','true'));
function webshop_cp_gl_vcbtne_cb(){
	global $webshop_cp_gl_vcbtne_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-vcbtne" id="webshop-cp-gl-vcbtne" value="true"'.checked('true',$webshop_cp_gl_vcbtne_value,false).'>';
	$html .= '<label for="webshop-cp-gl-vcbtne">Enable View Cart button.</label>';
	echo $html;
}

//Checkout button
$webshop_cp_gl_chbtne_value = sanitize_text_field(get_option('webshop-cp-gl-chbtne','true'));
function webshop_cp_gl_chbtne_cb(){
	global $webshop_cp_gl_chbtne_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-chbtne" id="webshop-cp-gl-chbtne" value="true"'.checked('true',$webshop_cp_gl_chbtne_value,false).'>';
	$html .= '<label for="webshop-cp-gl-chbtne">Enable Checkout button.</label>';
	echo $html;
}


//Enable spin icon
$webshop_cp_gl_spinen_value = sanitize_text_field(get_option('webshop-cp-gl-spinen','true'));
function webshop_cp_gl_spinen_cb(){
	global $webshop_cp_gl_spinen_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-spinen" id="webshop-cp-gl-spinen" value="true"'.checked('true',$webshop_cp_gl_spinen_value,false).'>';
	$html .= '<label for="webshop-cp-gl-spinen">Show spinner/Check icon on add to cart.</label>';
	echo $html;
}


//Reset cart form
$webshop_cp_gl_resetbtn_value = sanitize_text_field(get_option('webshop-cp-gl-resetbtn'));
function webshop_cp_gl_resetbtn_cb(){
	global $webshop_cp_gl_resetbtn_value;
	$html  = '<input type="checkbox" name="webshop-cp-gl-resetbtn" id="webshop-cp-gl-resetbtn" value="true"'.checked('true',$webshop_cp_gl_resetbtn_value,false).'>';
	$html .= '<label for="webshop-cp-gl-resetbtn">Resets quantity input , cart button to default stage.</label>';
	echo $html;
}

//Style Options Callback

//Popup Width
$webshop_cp_sy_pw_value = sanitize_text_field(get_option('webshop-cp-sy-pw','650'));
function webshop_cp_sy_pw_cb(){
	global $webshop_cp_sy_pw_value;
	$html  = '<input type="number" name="webshop-cp-sy-pw" id="webshop-cp-sy-pw" value="'.$webshop_cp_sy_pw_value.'">';
	$html .= '<label for="webshop-cp-sy-pw">Value in px (Default: 650).</label>';
	echo $html;
}

//Image Width
$webshop_cp_sy_imgw_value = sanitize_text_field(get_option('webshop-cp-sy-imgw','20'));
function webshop_cp_sy_imgw_cb(){
	global $webshop_cp_sy_imgw_value;
	$html  = '<input type="number" name="webshop-cp-sy-imgw" id="webshop-cp-sy-imgw" value="'.$webshop_cp_sy_imgw_value.'">';
	$html .= '<label for="webshop-cp-sy-imgw">Value in percentage (Default: 20).</label>';
	echo $html;
}

//Button Background Color
$webshop_cp_sy_btnbg_value = sanitize_text_field(get_option('webshop-cp-sy-btnbg','#777777'));
function webshop_cp_sy_btnbg_cb(){
	global $webshop_cp_sy_btnbg_value;
	$html  = '<input type="text" name="webshop-cp-sy-btnbg" id="webshop-cp-sy-btnbg" class="color-field" value="'.$webshop_cp_sy_btnbg_value.'"';
	echo $html;
}

//Button text Color
$webshop_cp_sy_btnc_value = sanitize_text_field(get_option('webshop-cp-sy-btnc','#ffffff'));
function webshop_cp_sy_btnc_cb(){
	global $webshop_cp_sy_btnc_value;
	$html  = '<input type="text" name="webshop-cp-sy-btnc" id="webshop-cp-sy-btnc" class="color-field" value="'.$webshop_cp_sy_btnc_value.'"';
	echo $html;
}

//Button Font Size
$webshop_cp_sy_btns_value = sanitize_text_field(get_option('webshop-cp-sy-btns','14'));
function webshop_cp_sy_btns_cb(){
	global $webshop_cp_sy_btns_value;
	$html  = '<input type="number" name="webshop-cp-sy-btns" id="webshop-cp-sy-btns" value="'.$webshop_cp_sy_btns_value.'">';
	$html .= '<label for="webshop-cp-sy-btns">Size in px (Default 14).</label>';
	echo $html;
}

//Button Border Radius
$webshop_cp_sy_btnbr_value = sanitize_text_field(get_option('webshop-cp-sy-btnbr','5'));
function webshop_cp_sy_btnbr_cb(){
	global $webshop_cp_sy_btnbr_value;
	$html  = '<input type="number" name="webshop-cp-sy-btnbr" id="webshop-cp-sy-btnbr" value="'.$webshop_cp_sy_btnbr_value.'">';
	$html .= '<label for="webshop-cp-sy-btnbr">Size in px (Default 5).</label>';
	echo $html;
}


//Table Border Size
$webshop_cp_sy_tbs_value = sanitize_text_field(get_option('webshop-cp-sy-tbs','0'));
function webshop_cp_sy_tbs_cb(){
	global $webshop_cp_sy_tbs_value;
	$html  = '<input type="number" name="webshop-cp-sy-tbs" id="webshop-cp-sy-tbs" value="'.$webshop_cp_sy_tbs_value.'">';
	$html .= '<label for="webshop-cp-sy-tbs">Size in px (Default 0).</label>';
	echo $html;
}


//Table Border Color
$webshop_cp_sy_tbc_value = sanitize_text_field(get_option('webshop-cp-sy-tbc','#ebe9eb'));
function webshop_cp_sy_tbc_cb(){
	global $webshop_cp_sy_tbc_value;
	$html  = '<input type="text" class="color-field" name="webshop-cp-sy-tbc" id="webshop-cp-sy-tbc" value="'.$webshop_cp_sy_tbc_value.'">';
	echo $html;
}



?>