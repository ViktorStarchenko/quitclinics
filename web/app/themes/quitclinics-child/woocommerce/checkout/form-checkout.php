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
<div class="checkout-wrapper <?php  echo (get_user_meta(get_current_user_id(), 'is_agreed', true) == 'agreed' ? ' agreed ' :''); ?> <?php  echo (get_user_meta(get_current_user_id(), 'is_verified', true) == 'verified' ? ' verified ' :''); ?> <?php echo get_user_meta($user_id, 'is_verified', true) ?>">
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
            <?php if (get_field('cloudcheck', 'option')) : ?>
                <ul class="cloudcheck-regions-list">
                    <?php foreach(get_field('cloudcheck', 'option') as $key => $cloudcheck_title) : ?>
                        <li data-region="<?php echo sanitize_title($cloudcheck_title['country']); ?>" class="<?php  echo ($key == 0 ?  ' show ' :''); ?>"><?php echo $cloudcheck_title['country']; ?></li>
                    <?php endforeach ?>
                </ul>
            <?php endif; ?>
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

        <div class="agreement-form-wrap">
            <form class="agreement-form" action="">
                <div class="form-inner">
                    <div class="form-group qc-form-group w100">
                        <div class="d-flex"><label class="bio">I confirm that I am authorised to provide the personal details presented and I consent to my information being passed to and checked with the document issuer, official record holder, a credit bureau and authorised third parties for the purpose of verifying my identity and address.</label></div>

                    </div>
                    <div class="qc-form-group w100">
                        <div class="form-check-group">
                            <div class="form-check">
                                <input class="form-check-input" name="is_agreed" type="checkbox" data-testid="checkbox" id="is_agreed" tabindex="-1" value="is_agreed">
                                <span class="custom-check-input"></span>
                                <div class="d-flex"><label class="form-check-label" for="is_agreed">I confirm that I have read and understand the above safety information</label></div>
                            </div>
                        </div>
                    </div>

                    <div class="qc-form-group w100">
                        <button type="submit" class="btn-body btn-blue bordered m-auto agreement-form-submit" >Confirm</button>
                    </div>
                </div>

            </form>
        </div>



        <div id="success" class="success"></div>
    </div>
</div>


<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
<?php wp_enqueue_script( 'agreement-form', get_theme_file_uri( '/assets/js/agreement-form.js' ), array('jq-351'), '1', true ); ?>
