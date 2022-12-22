<?php
/*
 * Plugin Name: Woocommerce add variation in archive|catalog
 * Description: Добавление вариации в архив/каталогтоваров
 * Version: 0.0.1
 * Author: Александр Боровлев
 * Author URI: https://vk.com/borovlioff
 * License: GPLv2 or later
 */

function wav_add_action() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_action( 'woocommerce_after_shop_loop_item', 'wav_add_variation', 10 );
}
 
add_action( 'init', 'wav_add_action', 10 );
 

function wav_add_variation() {
	global $product;
	global $woocommerce;
 
	if ( ! $product->is_type( 'variable' ) ) {
		return;
	}
 
	remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );

		$variations = $product->get_children();
	 	$available_variations = $product->get_attributes();
		
	?>
	<select>
	<?php
	$insert_defoult_option = false;
    foreach ($variations as $key => $variation_id) 
    { 
		
		$insert_defoult_option_title = "мастера";
		$insert_defoult_option_sub_title = "";
		$variation_product  = new WC_Product_Variation($variation_id);
		$variation_name = $variation_product->get_attribute("master");
		if($variation_name == ""){$variation_name = $variation_product->get_attribute("minuty"); $insert_defoult_option_title = "продолжительность"; $insert_defoult_option_sub_title = "мин.";}
		$price = $variation_product->get_price();
		if($insert_defoult_option == false){
		?>
			<option value="" selected>Выбрать <? print_r($insert_defoult_option_title)?></option> <?php $insert_defoult_option = true;?>
		<?php
		}
		?>
		<option value="<?php print_r($variation_id)?>" ><?php print_r($variation_name)?><? print_r($insert_defoult_option_sub_title)?> - <?php print_r($price)?> <span style="margin-left:1rem;">₽</span></option>
		  
		
		<?php
    }
	?>
		</select>
	<?php
}
 