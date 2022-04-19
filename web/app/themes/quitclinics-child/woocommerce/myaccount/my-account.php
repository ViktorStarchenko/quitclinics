<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_navigation' ); ?>

<div class="woocommerce-MyAccount-content  acf-section-<?php echo get_row_index(); ?>">

<!--    --><?php
//    // GET CURR USER
//    $current_user = wp_get_current_user();
//    if ( 0 == $current_user->ID ) return;
//
//    // GET USER ORDERS (COMPLETED + PROCESSING)
//    $customer_orders = get_posts( array(
//        'numberposts' => -1,
//        'meta_key'    => '_customer_user',
//        'meta_value'  => $current_user->ID,
//        'post_type'   =>'shop_order ',
//        'order' => 'desc',
//        'post_status' => array_keys( wc_get_is_paid_statuses() ),
//    ) );
//
//    // LOOP THROUGH ORDERS AND GET PRODUCT IDS
//    if ( ! $customer_orders ) return;
//    $product_ids = array();
//    foreach ( $customer_orders as $customer_order ) {
//
//    }
//    $last_order_date = $customer_orders[0]->post_date;
//
//    $date = date("Y-m-d");
//
//    $last_order_date = $customer_orders[0]->post_date;
//    $date = date("Y-m-d");
//
//
//    $product_ids = array_unique( $product_ids );
//    $product_ids_str = implode( ",", $product_ids );
//
//    //    DATE DIFFERENCE
//
//
//    function IntervalDays($CheckIn,$CheckOut){
//        $new_date = date("Y-m-d", strtotime($CheckIn));
//        $CheckInX = explode("-", $new_date);
//        $CheckOutX =  explode("-", $CheckOut);
//        $date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
//        $date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
//        $interval =($date2 - $date1)/(3600*24);
//// returns numberofdays
//        return  $interval ;
//
//    }
//    $diff = IntervalDays($last_order_date, $date);
//
//    $expiration_time = get_field('expiration_text', 'option')['expiration_time'];
//    if ($diff >= 0) { ?>
<!--          <div class="account__order-expiration-time">-->
<!--              <div class="account__order-expiration-text">-->
<!--                  --><?php //echo get_field('expiration_text', 'option')['expiration_item'] ?>
<!--              </div>-->
<!--              --><?php //if(get_field('expiration_text', 'option')['buttons_group']) : ?>
<!--                  <div class="btn-block --><?php // echo ((get_field('buttons_group')['hide_buttons'] == 'true') ? ' hidden-mob ' :''); ?><!--" ">-->
<!--                  --><?php //foreach(get_field('expiration_text', 'option')['buttons_group']['buttons'] as $button) : ?>
<!--                      <a href="--><?php //echo $button['button']['url'] ;?><!--" class="btn-body btn-blue --><?php // echo ($button['anchor'] ?  ' crane ' :''); ?><!--" data-mob-text="Apply now">--><?php //echo $button['button']['title'] ;?><!--</a>-->
<!--                  --><?php //endforeach; ?>
<!--              </div>-->
<!--            --><?php //endif; //edif buttons ?>
<!--          </div>-->
<!--    --><?php //}
//    ?>
    <div class="account__order-expiration-time">
        <div class="account__order-expiration-text">
            <?php echo get_field('expiration_text', 'option')['expiration_item'] ?>
        </div>
        <?php if(get_field('expiration_text', 'option')['buttons_group']) : ?>
        <div class="btn-block <?php  echo ((get_field('buttons_group')['hide_buttons'] == 'true') ? ' hidden-mob ' :''); ?>" ">
        <?php foreach(get_field('expiration_text', 'option')['buttons_group']['buttons'] as $button) : ?>
            <a href="<?php echo $button['button']['url'] ;?>" class="btn-body btn-blue <?php  echo ($button['anchor'] ?  ' crane ' :''); ?>" data-mob-text="Apply now"><?php echo $button['button']['title'] ;?></a>
        <?php endforeach; ?>
    </div>
    <?php endif; //edif buttons ?>
    </div>
    <?php if (get_field('expiration_text', 'option')['buttons_group']['buttons_alignment']) : ?>
        <style>
            .account__order-expiration-time {
                display: none;
            }
            .account__order-expiration-time .btn-block {
                justify-content: <?php echo get_field('expiration_text', 'option')['buttons_group']['buttons_alignment']; ?>;
            }
            @media screen and (max-width: 767px) {
                .account__order-expiration-time .btn-block {
                    justify-content: <?php echo get_field('expiration_text', 'option')['buttons_group']['buttons_alignment_mobile']; ?>;
                }
            }
        </style>
    <?php endif // end buttons_group styles ?>
    <?php
    /**
     * My Account content.
     *
     * @since 2.6.0
     */
    do_action( 'woocommerce_account_content' );
    ?>
</div>
<?php wp_enqueue_script( 'left-menu', get_theme_file_uri( '/assets/js/left-menu.js' ), array('jq-351'), '1', true ); ?>

