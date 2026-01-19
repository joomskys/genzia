<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$form_style = [
	//'--cms-form-field-border-color:var(--cms-sub-text)',
    '--cms-form-field-padding-end:70px',
    '--cms-form-field-padding-start:32px',
    '--cms-placeholder-color:var(--cms-body)',
    '--cms-form-field-height:60px',
    '--cms-form-field-radius:0',
    '--cms-form-field-border-width:1px',
    '--cms-form-field-border-width-hover:1px',
    '--cms-form-btn-color:var(--cms-menu)',
    '--cms-form-btn-color-hover:var(--cms-accent-regular)',
    '--cms-btn-height:60px',
    '--cms-btn-padding:0 32px',
    '--cms-form-btn-bg:transparent',
    '--cms-form-btn-bg-hover:transparent'
];
?>
<form method="get" class="woocommerce-product-search cms-wgsearch-form relative" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="<?php echo implode(';', $form_style); ?>">
	<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="woocommerce-product-search-field cms-wgsearch-field w-100" placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'genzia' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'genzia' ); ?>" class="absolute top right bottom"><?php 
		genzia_svgs_icon([
			'icon'      => 'core/search',
			'icon_size' => 20
		]);
	?></button>
	<input type="hidden" name="post_type" value="product" />
</form>