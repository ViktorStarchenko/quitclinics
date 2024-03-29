<?php
/**
 * Simple product continue button
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/continue-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
    return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <?php if (get_field('continue_button')) : ?>
    <div class="cart" >
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <a href="<?php echo get_field('continue_button')['url']; ?>" name="add-to-cart" class="single_add_to_cart_button button alt"><?php echo get_field('continue_button')['title']; ?></a>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
    <?php endif; ?>
<?php endif; ?>
