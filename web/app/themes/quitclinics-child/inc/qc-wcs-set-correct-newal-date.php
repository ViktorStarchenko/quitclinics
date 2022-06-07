<?php
add_action( 'woocommerce_subscription_status_active', 'reschedule_subscription', 10, 1 );
function reschedule_subscription($subscription) {
    if ( ! $subscription )
        return;

//    Get orders
    $customer_orders = [];
    foreach ( wc_get_is_paid_statuses() as $paid_status ) {
        $customer_orders += wc_get_orders( [
            'type'        => 'shop_order',
            'limit'       => - 1,
            'customer_id' => $subscription->get_user_id(),
            'status'      => $paid_status,
        ] );
    }

//    Get product period
    if ( sizeof( $subscription_items = $subscription->get_items() ) > 0 ) {
        $product_id = '';
        $product = '';
        foreach ( $subscription_items as $item_id => $item ) {
            $product = $item->get_product();
            //Examples of use
            $product->get_id();
            $product_id = wcs_get_canonical_product_id( $item ); // get product id directly from item
        }
    }
    $product_period = get_post_meta($product_id, '_subscription_period_interval')[0]. ' ' .get_post_meta($product_id, '_subscription_period')[0];

    //Update next payment date
    $start_date = $customer_orders[0]->get_date_created();
//    $oneday_ago = date( 'Y-m-d H:i:s', strtotime( '+'.$product_period, strtotime( current_time('Y-m-d H:i:s') )) );
    $period_ago = date( 'Y-m-d H:i:s', strtotime( '+'.$product_period, strtotime( $start_date )) );
    $year_ago = date( 'Y-m-d H:i:s', strtotime( '+1 minutes', strtotime( current_time('Y-m-d H:i:s') )) );

    $next_date = '';
    if (get_field('klaviyo_settings', 'option')['enable_5_minutes_lifetime'] == true) {
        $next_date = $year_ago;
    } else {
        $next_date = $period_ago;
    }


    $subscription->update_dates(array('next_payment' => $next_date));

//    Customers data
    $billing_email  = $customer_orders[0]->get_billing_email();
    $payment_method  = $customer_orders[0]->get_payment_method();

    // Customer billing information details
    $billing_first_name = $customer_orders[0]->get_billing_first_name();
    $billing_last_name  = $customer_orders[0]->get_billing_last_name();
    $billing_company    = $customer_orders[0]->get_billing_company();
    $billing_address_1  = $customer_orders[0]->get_billing_address_1();
    $billing_address_2  = $customer_orders[0]->get_billing_address_2();
    $billing_city       = $customer_orders[0]->get_billing_city();
    $billing_state      = $customer_orders[0]->get_billing_state();
    $billing_postcode   = $customer_orders[0]->get_billing_postcode();
    $billing_country    = $customer_orders[0]->get_billing_country();

    $next_payment = $subscription->get_date('next_payment');
    $subsctiption_start = $subscription->get_date('start');
    $payment_date =  date( 'Y-m-d H:i:s', strtotime($start_date) );

    $sub_obj = wcs_get_subscriptions_for_order( $customer_orders[0]->get_id() );
    $sub_id = array_keys($sub_obj)[0];
    $sub_url = get_site_url() . '/wp-admin/post.php?post='.$sub_id.'&action=edit';

    $profiles = [];
    $single = array(
        'subscription_id' => $sub_id,
        'subscription_url' => $sub_url,

        'email' => $billing_email,
        'first_name' => $billing_first_name,
        'last_name' => $billing_last_name,
        'company' => $billing_company,
        'address_1' => $billing_address_1,
        'address_2' => $billing_address_2,
        'country' => $billing_country,
        'city' => $billing_city,
        'region' => $billing_state,
        'postcode' => $billing_postcode,
        'payment_method' => $payment_method,

        'subscription_status' => 'completed',
        'subcription_next_payment' => $next_payment,
        'order_created' => $payment_date,
        'subscription_start' => $subsctiption_start
    );

    $profiles['profiles'][] = $single;
                $profiles = json_encode($profiles);

//            Klaviyo private key
                $klaviyoPrivateKey = '';
                if (get_field('klaviyo_settings', 'option')['api_key']) {
                    $klaviyoPrivateKey = get_field('klaviyo_settings', 'option')['api_key'];
                }
                $klaviyo_list_id = 'TtAbEp';

//            Send request
//                $curl = curl_init();
//                curl_setopt_array($curl, [
//                    CURLOPT_URL => "https://a.klaviyo.com/api/v2/list/".$klaviyo_list_id."/subscribe?api_key=".$klaviyoPrivateKey."",
//                    CURLOPT_RETURNTRANSFER => true,
//                    CURLOPT_ENCODING => "",
//                    CURLOPT_MAXREDIRS => 10,
//                    CURLOPT_TIMEOUT => 30,
//                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                    CURLOPT_CUSTOMREQUEST => "POST",
//                    CURLOPT_POSTFIELDS => $profiles,
//                    CURLOPT_HTTPHEADER => [
//                        "Accept: application/json",
//                        "Content-Type: application/json"
//                    ],
//                ]);
//
//                $response = curl_exec($curl);
//                $err = curl_error($curl);
//
//                curl_close($curl);
//
//                if ($err) {
//                    echo "cURL Error #:" . $err;
//                } else {
//                    return $response;
//                }
}
