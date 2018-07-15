<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}

?>

<div class="webshop-cp-opac"></div>
<div class="webshop-cp-modal">
	<div class="webshop-cp-container">
		<div class="webshop-cp-outer">
			<div class="webshop-cp-cont-opac"></div>
			<span class="webshop-cp-preloader webshop-cp-icon-spinner"></span>
		</div>
		<span class="webshop-cp-close webshop-cp-icon-cross"></span>

		<div class="webshop-cp-content"></div>
			
		<?php do_action('webshop_cp_before_btns'); ?>	
		<div class="webshop-cp-btns">
			<a class="webshop-cp-btn-vc xcp-btn" href="<?php echo wc_get_cart_url(); ?>"><?php _e('View Cart','added-to-cart-popup-woocommerce'); ?></a>
			<a class="webshop-cp-btn-ch xcp-btn" href="<?php echo wc_get_checkout_url(); ?>"><?php _e('Checkout','added-to-cart-popup-woocommerce'); ?></a>
		</div>
		<?php do_action('webshop_cp_after_btns'); ?>
	</div>
</div>