<?php
//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}
?>
<?php settings_errors(); ?>
<div class="webshop-cp-main-settings">
<form method="POST" action="options.php" class="webshop-cp-form">
	<?php settings_fields('webshop-cp-group'); ?>
	<?php do_settings_sections('webshop_cp'); ?>
	<?php submit_button(); ?>
</form>

