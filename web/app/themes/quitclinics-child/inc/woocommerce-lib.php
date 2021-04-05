<?php

/**
 * Display the product thumbnail in order received page
 **/
//add_filter( 'woocommerce_order_item_name', 'order_received_item_thumbnail_image', 10, 3 );
function order_received_item_thumbnail_image( $item_name, $item, $is_visible ) {
    // Targeting order received page only
    if( ! is_wc_endpoint_url('order-received') ) return $item_name;

    // Get the WC_Product object (from order item)
    $product = $item->get_product();

    if( $product->get_image_id() > 0 ){
        $product_image = '<span style="float:left;display:block;width:56px;">' . $product->get_image(array(150, 150)) . '</span>';
//        $item_name = $item_name;
        $item_name = $product_image . $item_name;
    }

    return $item_name;
}
function order_received_item_thumbnail_image2( $item_name, $item, $is_visible ) {
    // Targeting order received page only
    if( ! is_wc_endpoint_url('order-received') ) return $item_name;

    // Get the WC_Product object (from order item)
    $product = $item->get_product();

    if( $product->get_image_id() > 0 ){
        $product_image = '<span style="float:left;display:block;width:56px;">' . $product->get_image(array(150, 150)) . '</span>';
//        $item_name = $item_name;
        $item_name = $product_image;
    }

    return $item_name;
}



//ADD CART ENDPOINT TO ACCOUNT NAVIGATION
add_filter ( 'woocommerce_account_menu_items', 'add_cart_link' );
function add_cart_link( $menu_links ){

    // we will hook "anyuniquetext123" later
    $new = array( 'cart' => 'Cart' );

    // or in case you need 2 links
    // $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

    // array_slice() is good when you want to add an element between the other ones
    $menu_links = array_slice( $menu_links, 0, 1, true )
        + $new
        + array_slice( $menu_links, 1, NULL, true );


    return $menu_links;


}


/**
 * add_cart_link_endpoint
 **/
add_filter( 'woocommerce_get_endpoint_url', 'add_cart_link_endpoint', 10, 4 );
function add_cart_link_endpoint( $url, $endpoint, $value, $permalink ){

    if( $endpoint === 'cart' ) {

        // ok, here is the place for your custom URL, it could be external
        $url = '/cart';

    }
    return $url;

}




/**
 * Product page customization
 **/
// Remove breadcrumbs from shop & categories
add_filter( 'woocommerce_before_main_content', 'remove_breadcrumbs');
function remove_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
}

//REMOVE RELATED PRODUCTS
add_filter('woocommerce_product_related_posts_query', '__return_empty_array', 100);

//REMOVE Product notices
remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);



//ADD expiration to product description
function qclinics_product_expiration() {
    wc_get_template( 'single-product/expiration.php' );
}
add_action('woocommerce_single_product_summary', 'qclinics_product_expiration', 2);

//Add subtitle to product description
function qclinics_product_subtitle() {
    wc_get_template( 'single-product/subtitle.php' );
}
add_action('woocommerce_single_product_summary', 'qclinics_product_subtitle', 3);

//Add custom price to product description
function qclinics_product_price_custom() {
    wc_get_template( 'single-product/price-custom.php' );
}
add_action('woocommerce_single_product_summary', 'qclinics_product_price_custom', 10);

//Add steps to product description
function qclinics_product_steps() {
    wc_get_template( 'single-product/steps.php' );
}
add_action('woocommerce_single_product_summary', 'qclinics_product_steps', 25);

//Remove title from product description
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);


//Remove default price from product description
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

//Remove cart from product description
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

//Add continue button to product description
function qclinics_product_continue_button() {
    wc_get_template( 'single-product/continue-button.php' );
}
add_action('woocommerce_single_product_summary', 'qclinics_product_continue_button', 30);

//Remove meta from product description
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

//REMOVE featured image from gallery
add_filter('woocommerce_single_product_image_thumbnail_html', 'remove_featured_image', 10, 2);
function remove_featured_image($html, $attachment_id ) {
    global $post, $product;

    $featured_image = get_post_thumbnail_id( $post->ID );

    if ( $attachment_id == $featured_image )
        $html = '';

    return $html;
}



//Disable Billing postcode field required
add_filter( 'woocommerce_checkout_fields' , 'bbloomer_alternative_override_postcode_validation' );

function bbloomer_alternative_override_postcode_validation( $fields ) {
    $fields['billing']['billing_postcode']['required'] = false;
    $fields['shipping']['shipping_postcode']['required'] = false;
    return $fields;
}

add_filter( 'woocommerce_default_address_fields' , 'bbloomer_override_postcode_validation' );

function bbloomer_override_postcode_validation( $address_fields ) {
    $address_fields['postcode']['required'] = false;
    return $address_fields;
}



/**
 * Add new subscribtion interval
 **/
function eg_extend_subscription_period_intervals( $intervals ) {

    $intervals[8] = sprintf( __( 'for %s', 'my-text-domain' ), WC_Subscriptions::append_numeral_suffix( 8 ) );

    $intervals[12] = sprintf( __( 'for %s', 'my-text-domain' ), WC_Subscriptions::append_numeral_suffix( 12 ) );

    $intervals[24] = sprintf( __( 'for %s', 'my-text-domain' ), WC_Subscriptions::append_numeral_suffix( 24 ) );

    return $intervals;
}
add_filter( 'woocommerce_subscription_period_interval_strings', 'eg_extend_subscription_period_intervals' );



/**
 * REDIRECT NON LOGIN USERS TO LOGIN PAGE
 **/
add_action('template_redirect','check_if_logged_in');
function check_if_logged_in()
{
    $pageid = 680; // your checkout page id
    if(!is_user_logged_in() && is_page($pageid))
    {
        $url = add_query_arg(
            'redirect_to',
            get_permalink($pagid),
            site_url('/my-account/') // your my acount url
        );
        wp_redirect($url);
        exit;
    }
}


/**
 * Redirect users to custom URL based on their role after login
 **/
function wp_woo_custom_redirect( $redirect ) {

    // Get the first of all the roles assigned to the user
    $role = $user->roles[0];
    $dashboard = admin_url();

    if(get_field('redirect_link', 'options')) {
        $myaccount = get_permalink( wc_get_page_id(get_field('redirect_link', 'options')['title']) );
    }

//    if( $role == 'administrator' ) {
//
//        //Redirect administrators to the dashboard
//        $admin_redirect = get_option('admin_redirect');
//        $redirect = $admin_redirect;
//    } elseif ( $role == 'shop-manager' ) {
//
//        //Redirect shop managers to the dashboard
//        $shop_manager_redirect = get_option('shop_manager_redirect');
//        $redirect = $shop_manager_redirect;
//    } elseif ( $role == 'customer' || $role == 'subscriber' ) {
//
//        //Redirect customers and subscribers to the "My Account" page
////        $customer_redirect = get_option('customer_redirect');
//        $customer_redirect = $myaccount;
//        $redirect = $customer_redirect;
//    } else {
//
//        //Redirect any other role to the previous visited page or, if not available, to the home
////        $redirect = wp_get_referer() ? wp_get_referer() : home_url();
//
////        $redirect = $myaccount;
//    }
    $redirect = $myaccount ? $myaccount : home_url();
    return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wp_woo_custom_redirect', 10, 2 );
add_filter( 'woocommerce_registration_redirect', 'wp_woo_custom_redirect', 10, 2 );


function bewpi_allowed_roles_to_download_invoice($allowed_roles) {
    // available roles: shop_manager, customer, contributor, author, editor, administrator
    $allowed_roles[] = "administrator";
    // end so on..
    return $allowed_roles;
}
add_filter( 'bewpi_allowed_roles_to_download_invoice', 'bewpi_allowed_roles_to_download_invoice', 10, 2 );



//ADD expiration to product description
function qclinics_email_order_code($additional_content = false) {
    wc_get_template( 'emails/email-order-code.php', array('additional_content' => $additional_content) );
}
add_action('woocommerce_email_order_code', 'qclinics_email_order_code', 5);


add_filter( 'wcs_allow_synced_product_early_renewal', '__return_true', 10 );