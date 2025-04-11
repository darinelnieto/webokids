<?php
/**
 * 
 * Default archive.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$posttype = get_queried_object();
switch($posttype->taxonomy)
{
    case 'product_cat':
		get_template_part('templates/archive-product-template');
	break;
}
?>