<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( WC()->cart && ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				/**
				 * This filter is documented in woocommerce/templates/cart/cart.php.
				 *
				 * @since 2.1.0
				 */
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> d-flex flex-nowrap gap-5 align-items-center ">
					
					<?php if ( empty( $product_permalink ) ) : ?>
						<div class="flex-basic d-flex flex-nowrap gap-20 align-items-center">
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="flex-basic d-flex flex-nowrap gap-20 align-items-center">
					<?php endif; ?>
						<div class="thumb bg-bg-light cms-radius-4 overflow-hidden"><?php printf('%s', $thumbnail); ?></div>
						<div class="flex-basic">
							<div class="text-md font-500 lh-1 text-menu text-hover-accent-regular product-title"><?php 
								echo wp_kses_post( $product_name ); 
							?></div>
							<div class="cms-mini-cart-item-data pt-10 empty-none"><?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<div class="cms-mini-cart-quantity pt-10 text-accent-regular">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</div>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
					<?php if ( empty( $product_permalink ) ) : ?>
						</div>
					<?php else : ?>
						</a>
					<?php endif; ?>
					<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a role="button" href="%s" class="remove remove_from_cart_button flex-auto cms-box-24 circle bg-menu text-white bg-hover-error text-hover-white" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" data-success_message="%s">'.genzia_svgs_icon([
									'icon'      => 'core/close',
									'icon_size' => 10,
									'echo'      => false
								]).'</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								/* translators: %s is the product name */
								esc_attr( sprintf( __( 'Remove %s from cart', 'genzia' ), wp_strip_all_tags( $product_name ) ) ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() ),
								/* translators: %s is the product name */
								esc_attr( sprintf( __( '&ldquo;%s&rdquo; has been removed from your cart', 'genzia' ), wp_strip_all_tags( $product_name ) ) )
							),
							$cart_item_key
						);
					?>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<div class="woocommerce-mini-cart__total total">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</div>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<div class="woocommerce-mini-cart__buttons buttons d-flex gap-24 pt-25"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></div>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'genzia' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
