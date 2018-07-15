<?php 

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}

global $webshop_cp_gl_qtyen_value;

$cart = WC()->cart->get_cart();

$total_number_of_cartridges = 0;
$total_number_of_machines = 0;

foreach($cartridges as $cartridge){
	$cartridge->price = wc_price(wc_get_product($cartridge->ID)->get_price());
	$cart = WC()->cart->get_cart();
	$cartridge->cart_item = (array_key_exists($cartridge->cart_key, $cart) ? $cart[$cartridge->cart_key] : NULL);
	$total_number_of_cartridges += $cartridge->cart_item['quantity'];
}

//error_log(print_r($cart, true));

$machine_cart_item = array_key_exists($machine->cart_key, $cart) ? $cart[$machine->cart_key] : NULL;

$machine_product = wc_get_product($machine->ID);
$machine_thumbnail = get_the_post_thumbnail($machine->ID, 'medium' );
//$machine_permalink = the_permalink($machine->ID);
$machine_name = $machine->post_name ;
$machine_price = wc_price(wc_get_product($machine->ID)->get_price());
$total_number_of_machines = $machine_cart_item['quantity'];

//Quantity input
$max_value = apply_filters( 'woocommerce_quantity_input_max', $machine_product->get_max_purchase_quantity(), $machine_product );
$min_value = apply_filters( 'woocommerce_quantity_input_min', $machine_product->get_min_purchase_quantity(), $machine_product );
$step      = apply_filters( 'woocommerce_quantity_input_step', 1, $machine_product );
$pattern   = apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' );

//$min_value = 1;	//
$total_discount_amount = 0;

$fee_array = WC()->cart->get_fees(); //since negative fees makes up the discount
foreach ($fee_array as $key => $value) {
	if(isset($value->total))
	$total_discount_amount += $value->total;
}

// echo '<pre>';
// //print_r($cart);
// //print_r($machine);
// //print_r($cartridges);
// echo '</pre>';

?>
<div class="webshop-cp-pimg-machine">
	<td class="webshop-cp-pimg"><a href="<?php echo the_permalink($machine->ID); ?>"><?php echo $machine_thumbnail; ?></a></td>
</div>
<table class="webshop-cp-pdetails clearfix">
	<tr class="info-store" data-webshop_cp_key="<?php echo $machine->cart_key; ?>" data-webshop_cp_product_key="<?php echo $machine->ID; ?>">
		<td class="webshop-cp-remove" style="display:none;"><span class="webshop-cp-icon-cross webshop-cp-remove-pd"></span></td>
		<td class="webshop-cp-ptitle"><a href="<?php echo the_permalink($machine->ID); ?>"><?php echo $machine_name; ?></a>

		<td class="webshop-cp-pprice"><?php echo  $machine_price; ?></td>

		<td class="webshop-cp-pqty">
			<?php if ( $machine_product->is_sold_individually() || !$webshop_cp_gl_qtyen_value ): ?>
				<span><?php echo !is_null($machine_cart_item) ? $machine_cart_item['quantity'] : 0 ; ?></span>				
			<?php else: ?>
				<div class="webshop-cp-qtybox">
				<span class="xcp-minus xcp-chng">-</span>
				<input type="number" class="webshop-cp-qty" max="<?php esc_attr_e( 0 < $max_value ? $max_value : '' ); ?>" min="<?php esc_attr_e($min_value); ?>" step="<?php echo esc_attr_e($step); ?>" value="<?php echo !is_null($machine_cart_item) ? $machine_cart_item['quantity'] : 0 ; ?>" pattern="<?php esc_attr_e( $pattern ); ?>">
				<span class="xcp-plus xcp-chng">+</span></div>
			<?php endif; ?>
		</td>
	</tr>
</table>
<!-- <pre>
    <?php
        //print_r($cart);
        //print_r($cartridges);
    ?>
</pre> -->
<div class="clearfix cartridges-list">
		<?php if ( count($cartridges) > 0 ):

			foreach ($cartridges as $cartridge) { 
				 $cartridge_product = wc_get_product($cartridge->ID);
				 $cartridge_max_value = $cartridge_product->get_max_purchase_quantity();
				 $cartridge_min_value = $cartridge_product->get_min_purchase_quantity();
				
				 $cartridge_min_value = 0; //overriding for now
				
				 ?>
					<div class="cartridge-container webshop-cp-pdetails clearfix">
						
						<div class="info-store" data-webshop_cp_key="<?php echo $cartridge->cart_key; ?>" data-webshop_cp_product_key="<?php echo $cartridge->ID; ?>">
							<div class="webshop-cp-remove" style="display:none;"><span class="webshop-cp-icon-cross webshop-cp-remove-pd"></span></div>
							
							<div class="webshop-cp-pimg-cartridge">
								<a href="<?php echo the_permalink($cartridge->ID); ?>"><?php echo get_the_post_thumbnail($cartridge->ID, 'medium' ); ?></a>
								<div class="webshop-cp-ptitle-cartridge">
									<a href="<?php echo the_permalink($cartridge->ID); ?>"><?php echo $cartridge->post_name ; ?></a>
								</div>
								<div class="webshop-cp-pprice-cartridge"><?php echo wc_price(wc_get_product($cartridge->ID)->get_price()) ; ?>
								</div>

								<div class="webshop-cp-pqty-cartridge">
									<?php if ( $cartridge_product->is_sold_individually() || !$webshop_cp_gl_qtyen_value ): ?>
										<span><?php echo !is_null($cartridge->cart_item) ? $cartridge->cart_item['quantity'] : 0 ; ?></span>				
									<?php else: ?>
										<div class="webshop-cp-qtybox">
										<span class="xcp-minus xcp-chng">-</span>
										<input type="number" class="webshop-cp-qty" max="<?php esc_attr_e( 0 < $cartridge_max_value ? $cartridge_max_value : '' ); ?>" min="<?php esc_attr_e($cartridge_min_value); ?>" step="<?php echo esc_attr_e($step); ?>" value="<?php echo !is_null($cartridge->cart_item) ? $cartridge->cart_item['quantity'] : 0 ; ?>" pattern="<?php esc_attr_e( $pattern ); ?>">
										<span class="xcp-plus xcp-chng">+</span></div>
									<?php endif; ?>
								</div>
							</div>

						</div>

					</div>

			<?php } endif; ?>
</div>
<div class="webshop-cp-pshipping webshop-clearfix"><span class="xcp-totxt"><?php _e('Shipping','added-to-cart-popup-woocommerce');?> : </span><span class="xcp-pshipping"><?php echo wc_price(WC()->cart->shipping_total); ?></span></div>
<div class="webshop-cp-pdiscount webshop-clearfix"><span class="xcp-totxt"><?php _e('Discount applied','added-to-cart-popup-woocommerce');?> : </span><span class="xcp-pshipping"><?php echo wc_price( $total_discount_amount ); ?></span></div>
<div class="webshop-cp-ptotal"><span class="xcp-totxt"><?php _e('Total(first cartridge free with Machine)','added-to-cart-popup-woocommerce');?> : </span><span class="xcp-ptotal"><?php echo wc_price(WC()->cart->total) ; ?></span></div>
<input type="hidden" id="freecartridgesadded" value="<?php echo ($total_number_of_machines > $total_number_of_cartridges) ? 'true' : 'false';  ?>">

<script type="text/javascript">

	//Not proud of this but in the current situation this will work
	var areFreeCartridgesAdded = document.getElementById("freecartridgesadded").value;

	//NOTE: jQuery doesn't work
	//Disable the link if above condition is not met
	if (areFreeCartridgesAdded == 'true'){
		document.getElementsByClassName("webshop-cp-btn-ch")[0].href = '#';
	}
	else
		document.getElementsByClassName("webshop-cp-btn-ch")[0].href = '<?php echo wc_get_checkout_url(); ?>'; 

</script>

