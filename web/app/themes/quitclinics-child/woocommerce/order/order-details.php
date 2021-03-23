<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.6.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited



if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>

<section class="woocommerce-order-details">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

<!--	<h2 class="woocommerce-order-details__title">--><?php //esc_html_e( 'Order details', 'woocommerce' ); ?><!--</h2>-->

	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

		<thead>
			<tr>
				<th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) {
				$product = $item->get_product();

				wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				);
			}

			do_action( 'woocommerce_order_details_after_order_table_items', $order );
			?>
		</tbody>

		<tfoot>
			<?php
            $order_total = $order->get_order_item_totals(); ?>
                    <tr>
						<th scope="row"><?php echo esc_html( $order_total['order_total']['label'] ); ?></th>
						<td><?php echo $order_total['order_total']['value'] ; ?></td>
					</tr>

			<?php if ( $order->get_customer_note() ) : ?>
				<tr>
					<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>
			<?php endif; ?>
		</tfoot>
	</table>

<!-- Remove related orders	--><?php //do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

<!--///////////////////////////////////////-->


<!--ORDER DETAILS TOTAL-->
<div class="woocommerce-order-details--total">
    <h2><?php esc_html_e( 'Total', 'woocommerce' ); ?></h2>
    <table cellspacing="0" class="shop_table">

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                <td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

            <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

            <?php wc_cart_totals_shipping_html(); ?>

            <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

            <tr class="shipping">
                <th><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></th>
                <td data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
            </tr>

        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <tr class="fee">
                <th><?php echo esc_html( $fee->name ); ?></th>
                <td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
            </tr>
        <?php endforeach; ?>

        <?php
        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                /* translators: %s location. */
                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
            }

            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                    ?>
                    <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <th><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
                        <td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr class="tax-total">
                    <th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
                    <td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
                </tr>
                <?php
            }
        }
        ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

        <tr class="order-total">
            <th><?php esc_html_e( 'Order total', 'woocommerce' ); ?></th>
            <td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php echo $order_total['order_total']['value'] ; ?></td>
        </tr>

        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    </table>
    <?php if(get_field('apply_for_your_consultation', 'option')) : ?>
        <div class="btn-block">
            <a href="<?php echo get_field('apply_for_your_consultation', 'option')['url'] ;?>" class="btn-body btn-blue"><?php echo get_field('apply_for_your_consultation', 'option')['title'] ;?></a>
        </div>
    <?php endif; //edif buttons ?>
</div>

</div>


<!--In case we will need Invite a friend and be rewarded -->
<!--<div class="refer-friend"> -->
<!--    <h5>Invite a friend and be rewarded</h5>-->
<!--    <p>loLorem ipsum dolor sit amet, consectetur adipiscing elit. In eget sapien tempor, facilisis orci in, ornare erat. Suspendisse faucibus, nisl id suscipit rhoncus.</p>-->
<!--    <div class="btn-block">-->
<!--        <a href="#" class="btn-body btn-blue">Refer a friend</a>-->
<!--    </div>-->
<!--</div>-->


<!--///////////////////////////////////////-->

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
?>
