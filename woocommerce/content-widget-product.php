<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

?>
<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="d-flex flex-nowrap gap-20 align-items-center">
		<div class="thumb bg-bg-light cms-radius-10 overflow-hidden"><?php 
			printf('%s', $product->get_image('woocommerce_gallery_thumbnail')); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
		?></div>
		<div class="flex-basic">
			<div class="text-md font-700 text-menu text-hover-accent-regular product-title"><?php echo wp_kses_post( $product->get_name() ); ?></div>
			<div class="price text-md"><?php 
				printf('%s', $product->get_price_html()); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
			?></div>
			<?php if ( ! empty( $show_rating ) ) : ?>
				<?php echo wc_get_rating_html( $product->get_average_rating() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
		</div>
	</a>
	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
