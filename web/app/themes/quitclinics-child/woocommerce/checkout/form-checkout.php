<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );


// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<div class="notification-wrapper">
    <?php echo get_field('prescription_expiraion', 'option'); ?>
</div>
<div class="checkout-wrapper <?php  echo (get_user_meta(get_current_user_id(), 'is_agreed', true) == 'agreed' ? ' ready ' :''); ?> <?php  echo (get_user_meta(get_current_user_id(), 'is_verified', true) == 'verified' ? ' ready ' :''); ?> <?php echo get_user_meta($user_id, 'is_verified', true) ?>">
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <?php if ( $checkout->get_checkout_fields() ) : ?>

            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

            <div class="col2-set" id="customer_details">
                <div class="col-12">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>

                <!--			<div class="col-2">-->
                <!--				--><?php //do_action( 'woocommerce_checkout_shipping' ); ?>
                <!--			</div>-->
            </div>

            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

        <?php endif; ?>




        <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

        <!--	<h3 id="order_review_heading">--><?php //esc_html_e( 'Your order', 'woocommerce' ); ?><!--</h3>-->

        <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

        <div id="order_review" class="woocommerce-checkout-review-order">

            <div class="payment-review">
                <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
                <?php do_action( 'woocommerce_checkout_order_review' ); ?>
            </div>

        </div>

        <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

    </form>
    <div class="cloudcheck">
        <div class="cloudcheck-form-wrap">

            <h3 class="title-h5">Identify Verification</h3>

            <?php if (get_field('cloudcheck', 'option')) { ?>
                <div class="dropdown-body cloudcheck-regions-list-wrapper">
                    <span onclick="" class="dropbtn dropdown-heading" data-dropdown="search-nav"><?php echo get_field('cloudcheck', 'option')[0]['country']; ?></span>
                    <ul id="myDropdown" class="cloudcheck-regions-list dropdown-content" data-dropdown="search-nav">
                        <?php foreach ( get_field('cloudcheck', 'option') as $key => $cloudcheck_title )  { ?>
                            <li class="tabs-nav__item dropdown-item <?php  echo ($key == 0 ?  ' show ' :''); ?>" data-tab-name="tab-board-members" data-region="<?php echo sanitize_title($cloudcheck_title['country']); ?>"><?php echo $cloudcheck_title['country']; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>



            <?php if (get_field('cloudcheck', 'option')) : ?>
                <div class="cloudcheck-region-body">
                    <?php foreach(get_field('cloudcheck', 'option') as $key => $cloudcheck) : ?>
                        <div  data-region="<?php echo sanitize_title($cloudcheck['country']); ?>" class="cloudcheck-region-box <?php  echo ($key == 0 ?  ' show ' :''); ?>">
                            <?php echo $cloudcheck['body']; ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif; ?>
        </div>

        <div id="success" class="success"></div>
    </div>
</div>


<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
