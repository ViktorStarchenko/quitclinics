<?php
if (!defined('ABSPATH')) exit;

include_once ('woocommerce-klaviyo-add-to-list.php');

class WoocommerceKlaviyoApi {
    public function __construct() {

    }

    public function wckl_subscribe_to_list($order_id, $post_id) {

        $profile = $this->wckl_get_profile_data($order_id);

        //Klaviyo private key
        $woocommerceKlaviyoAddToList = new WoocommerceKlaviyoAddToList();
        $klaviyoPrivateKey = $woocommerceKlaviyoAddToList->get_klaviyo_private_key();

        global $post;
        $custom = get_post_custom($post_id);
        $klaviyo_list_id = isset($custom["klaviyo_list_id"][0])?$custom["klaviyo_list_id"][0]:'';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://a.klaviyo.com/api/v2/list/".$klaviyo_list_id."/subscribe?api_key=".$klaviyoPrivateKey."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $profile,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function wckl_add_to_list($order_id, $integration_id) {

        $profile = $this->wckl_get_profile_data($order_id);

        //Klaviyo private key
        $woocommerceKlaviyoAddToList = new WoocommerceKlaviyoAddToList();
        $klaviyoPrivateKey = $woocommerceKlaviyoAddToList->get_klaviyo_private_key();

        global $post;
        $custom = get_post_custom($integration_id);
        $klaviyo_list_id = isset($custom["klaviyo_list_id"][0])?$custom["klaviyo_list_id"][0]:'';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://a.klaviyo.com/api/v2/list/".$klaviyo_list_id."/members?api_key=".$klaviyoPrivateKey."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $profile,
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function wckl_get_integrations() {
        $args = array(
            'post_type' => 'wckl_intergation',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids'
        );
        $wckl_intergations = array();
        $wckl_query = new WP_Query( $args );
        while($wckl_query->have_posts()) : $wckl_query->the_post();
            $wckl_intergations[]['post_id'] = get_the_ID();
        endwhile;
        wp_reset_postdata();


        return $wckl_intergations;
    }

    public function wckl_get_integrations_by_trigger($action_trigger) {
        $args = array(
            'post_type' => 'wckl_intergation',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_key'    => 'klaviyo_action_trigger',
            'meta_value'  => $action_trigger,
        );
        $wckl_intergations = array();
        $wckl_query = new WP_Query( $args );
        while($wckl_query->have_posts()) : $wckl_query->the_post();
            $wckl_intergations[]['post_id'] = get_the_ID();
        endwhile;
        wp_reset_postdata();


        return $wckl_intergations;
    }

    public function wckl_get_lists() {
        $woocommerceKlaviyoAddToList = new WoocommerceKlaviyoAddToList();
        $klaviyoPrivateKey = $woocommerceKlaviyoAddToList->get_klaviyo_private_key();
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://a.klaviyo.com/api/v2/lists?api_key=".$klaviyoPrivateKey."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    public function wckl_get_profile_data($order_id) {
        if ( ! $order_id )
            return;

        // Getting an instance of the order object

        $order = new WC_Order($order_id);

        // Get the Customer billing email
        $billing_email  = $order->get_billing_email();
        $payment_method  = $order->get_payment_method();

        // Customer billing information details
        $billing_first_name = $order->get_billing_first_name();
        $billing_last_name  = $order->get_billing_last_name();
        $billing_company    = $order->get_billing_company();
        $billing_address_1  = $order->get_billing_address_1();
        $billing_address_2  = $order->get_billing_address_2();
        $billing_city       = $order->get_billing_city();
        $billing_state      = $order->get_billing_state();
        $billing_postcode   = $order->get_billing_postcode();
        $billing_country    = $order->get_billing_country();

        $items = $order->get_items();

        //Loop through them, you can get all the relevant data:

        $profiles = [];
        $single = array(
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
        );
        $profiles['profiles'][] = $single;

        return json_encode($profiles);

    }
}