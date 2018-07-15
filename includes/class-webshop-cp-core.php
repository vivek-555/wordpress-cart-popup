<?php

if(!defined('ABSPATH')){
	return;
}

class Webshop_CP_Core{

	protected static $instance = null;

	public $action = null;

	const MACHINE_SKU = 'MAC-1';

	//Get instance
	public static function get_instance(){
		if(self::$instance === null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct(){
		add_action('wc_ajax_webshop_cp_add_to_cart',array($this,'webshop_cp_add_to_cart'));
		add_action('wc_ajax_webshop_cp_update_cart',array($this,'webshop_cp_update_cart'));
		add_filter('woocommerce_add_to_cart_fragments',array($this,'set_ajax_fragments'),10,1);
		add_action('woocommerce_add_to_cart',array($this,'set_last_added_cart_item_key'),10,6);

		//added later by vivek
		add_action( 'woocommerce_cart_calculate_fees',array($this,'cart_custom_discount') );
	}

	function get_machines_and_cartridges_for_cart(){
		
		//Bring machine
		$args     = array( 'post_type' => 'product', 'product_cat' => 'machines' );
		$machines = get_posts($args); //extract the first element
		$machine = reset($machines);
		
		//Bring cartridges ordered by their price asc
		$args     = array( 'post_type' => 'product', 'product_cat' => 'cartridges', 'orderby' => 'price', 'order'=>'ASC');
		$cartridges = get_posts( $args );

		//extract cart_key for machine
		$machine->cart_key = WC()->cart->generate_cart_id($machine->ID);
		
		//extract cart_key for cartridges
		foreach($cartridges as $cartridge){
			$cartridge->cart_key = WC()->cart->generate_cart_id($cartridge->ID);			
		}
		
		return array(
			'machine' => $machine,
			'cartridges' => $cartridges
		);
	}

	//Get cart Content
	public function get_cart_content(){
		global $webshop_cp_gl_pden_value;
		
		$response = $this->get_machines_and_cartridges_for_cart();
		
		$machine = $response['machine'];
		$cartridges = $response['cartridges'];
		
		//Get last cart item key
		$cart_item_key = get_option('webshop_cp_added_cart_key');

		if(!$cart_item_key || !$this->action)
			return;

		//Remove from the database
		delete_option('webshop_cp_added_cart_key');

		$notice = $this->get_notice_html();

		$args = array(
			'cart_item_key' => $cart_item_key,
			'action' 		=> $this->action,
			'machine' => $machine,
			'cartridges' => $cartridges
		);
		
		ob_start();
		wc_get_template('webshop-cp-content.php',$args,'',WEBSHOP_CP_PATH.'/templates/');
		return $notice.ob_get_clean();
	}

	public function get_notice_html(){

		if(!$this->action) return;

		switch ($this->action) {
			case 'add':
				$notice = __('Product successfully added to your cart','added-to-cart-popup-woocommerce');
				break;

			case 'update':
				$notice = __('Product updated successfully','added-to-cart-popup-woocommerce');
				break;

			case 'remove':
				$notice = __('Product removed from your cart','added-to-cart-popup-woocommerce');
				break;

		}

		return '<div class="webshop-cp-atcn webshop-cp-success"><span class="webshop-cp-icon-check"></span>'.$notice.'</div>';
	}


	//add to cart ajax on single product page
	public function webshop_cp_add_to_cart(){
		global $woocommerce,$webshop_cp_gl_qtyen_value,$webshop_cp_gl_ibtne_value;

		if(!isset($_POST['action']) || $_POST['action'] != 'webshop_cp_add_to_cart' || !isset($_POST['add-to-cart'])){
			die();
		}
		
		// get woocommerce error notice
		$error = wc_get_notices( 'error' );
		$html = '';

		if( $error ){
			// print notice
			ob_start();
			foreach( $error as $value ) {
				wc_print_notice( $value, 'error' );
			}

			$js_data =  array(
				'error' => ob_get_clean()
			);

			wc_clear_notices(); // clear other notice
			wp_send_json($js_data);
		}
		else {
			// trigger action for added to cart in ajax
			do_action( 'woocommerce_ajax_added_to_cart', intval( $_POST['add-to-cart'] ) );

			wc_clear_notices(); // clear other notice
			WC_AJAX::get_refreshed_fragments();	
		}

		die();
	}


	// Set ajax fragments
	public function set_ajax_fragments($fragments){

		$cart_content = $this->get_cart_content();

		//Cart content
		$fragments['div.webshop-cp-content'] = '<div class="webshop-cp-content">'.$cart_content.'</div>';

		return $fragments;
	}


	//Store last added cart item key
	public function set_last_added_cart_item_key($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data){
		$this->action = 'add';
		update_option('webshop_cp_added_cart_key',$cart_item_key);
	}


	//Update cart quantity
	public function webshop_cp_update_cart(){
		
		//Form Input Values
		$cart_key = sanitize_text_field($_POST['cart_key']);
		$new_qty = (float) $_POST['new_qty'];
		$product_id = (float) $_POST['product_id'];

		if(!is_numeric($new_qty) || $new_qty < 0 || !$cart_key || !is_numeric($product_id) || $product_id < 0){
			wp_send_json(array('error' => __('Something went wrong','side-cart-woocommerce')));
		}
		
// 		$cart_success = $new_qty == 0 ? WC()->cart->remove_cart_item($cart_key) : WC()->cart->set_quantity($cart_key,$new_qty);

		if($new_qty ==0){
			$cart_success = WC()->cart->remove_cart_item($cart_key);
		}else{
			$cart = WC()->cart->get_cart();
			
			if (array_key_exists($cart_key, $cart)){
				$cart_success = WC()->cart->set_quantity($cart_key, $new_qty);
			}else{
				$cart_success = WC()->cart->add_to_cart($product_id, $new_qty);
			}
		}
		
		if($cart_success){
			$this->action = $new_qty == 0 ? 'remove' : 'update';
			update_option('webshop_cp_added_cart_key',$cart_key);
			WC_AJAX::get_refreshed_fragments();
		}
		else{
			if(wc_notice_count('error') > 0){
	    		echo wc_print_notices();
			}
		}
		die();
	}

	//Applies the custom discount
	function cart_custom_discount(){

		$discount_total = 0;
		$discount_text = __( 'Discount: Cartridge free with every Machine', 'woocommerce' );
		$sku_price_map = [];

		$cart = WC()->cart->get_cart();

		foreach($cart as $key => $value){
			$cart_item = $value;
			$item_sku = $value['data']->get_sku();
			$item_price = $value['data']->get_price();
			
			$sku_price_map[strtolower($item_sku)] = array( 'price' => $item_price, 'quantity' => $value['quantity'] );
		}

		// error_log(print_r($sku_price_map, true));
		$eligible_skus_for_discount = $this->get_discounted_sku_prices($sku_price_map);
		// error_log(print_r($eligible_skus_for_discount, true));

		if(sizeof( $eligible_skus_for_discount) > 0 ){ // if there is no eligible candidate for discount then skip below
			$discount_total = array_sum($eligible_skus_for_discount);
		}

		if ($discount_total > 0) {

			$discount_total *= -1;
			WC()->cart->add_fee( $discount_text, $discount_total, false );//add negative fees for discount
		}
	}

	//returns the price array of all the discounted SKUs
	function get_discounted_sku_prices($sku_price_map){

		//for eligibility a machine has to exist in the cart else promotional code will not be applied
		if (!array_key_exists(strtolower(self::MACHINE_SKU), $sku_price_map))
			return array();

		// error_log(print_r($sku_price_map, true));
		$machine_quanity = $sku_price_map[strtolower(self::MACHINE_SKU)]['quantity'];

		//Keep only cartridges SKUs for discount calculation
		$filterOutKeys = [strtolower(self::MACHINE_SKU)];
		$sku_price_map = array_diff_key( $sku_price_map, array_flip( $filterOutKeys ) );

		if(sizeof($sku_price_map) == 0)
			return array();

		//use uasort instead of usort because it preserves the index
		uasort($sku_price_map, function($a, $b) {
    		return $a['price'] - $b['price'];
		});

		$discount_total = 0;
		$index = 0;
		$price_array = [];

		foreach ($sku_price_map as $key => $value) {
			
			$repetition =  $value['quantity'];
			$price_array_curr_sku = array_fill($index, $repetition, $value['price'] );
			$price_array = array_merge( $price_array,  array_values( $price_array_curr_sku) );

			$index += $repetition; //starting index for next loop
		}

		return array_slice($price_array, 0, $machine_quanity);//return the price array for discounted SKUs
	}


}


?>
