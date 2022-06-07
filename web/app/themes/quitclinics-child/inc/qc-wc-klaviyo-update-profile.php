<?php
add_action( 'woocommerce_subscription_status_active', 'qc_klaviyo_update_profile', 10, 1 );
function qc_klaviyo_update_profile($subscription) {
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

    $start_date = $customer_orders[0]->get_date_created();
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


    // Get profile ID
    function get_klaviyo_profile_id() {
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.klaviyo.com/api/v2/people/search?email='.$billing_email.'&api_key='.$klaviyoPrivateKey.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Cookie: __cf_bm=c9aqU_cEdLaX5.mNBvrRHWouKiK3r1rhbGNLG81AVVc-1653657187-0-Aa+4eE/lic3GWhVMogzd/BrSeJo+HPSHMrLBHQU/dQANFjmCfeNACyRGliY8gSM0bCDnTkqPkNeYC1yaqHQMxic='
        ),
    ));

    $profile = curl_exec($curl);

    curl_close($curl);
    return $profile;

    $profile = json_decode($profile);


    // Update klaviyo profile
    $curl = curl_init();

    $query_params = http_build_query($single, '', '&');

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.klaviyo.com/api/v1/person/'.$profile->id.'?'.$query_params.'&api_key='.$klaviyoPrivateKey.'',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Cookie: __cf_bm=c9aqU_cEdLaX5.mNBvrRHWouKiK3r1rhbGNLG81AVVc-1653657187-0-Aa+4eE/lic3GWhVMogzd/BrSeJo+HPSHMrLBHQU/dQANFjmCfeNACyRGliY8gSM0bCDnTkqPkNeYC1yaqHQMxic='
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;


}
