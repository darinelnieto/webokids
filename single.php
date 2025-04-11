<?php
/**
 * 
 * Default single.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if( $product):
	wc_get_template_part('single', 'product');
endif; ?>