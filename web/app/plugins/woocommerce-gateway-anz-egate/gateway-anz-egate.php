<?php
/*
 * Plugin Name: WooCommerce ANZ eGate Gateway
 * Plugin URI: https://woocommerce.com/products/anz-egate/
 * Woo: 18739:a80fbcb4d8d2822daf85442b2d647add
 * Description: Use ANZ eGate as a credit card processor for WooCommerce (either Merchant or Server hosted). An ANZ Merchant (Australia) account is required.
 * Version: 3.0.10
 * Author: Tyson Armstrong
 * Author URI: http://tysonarmstrong.com/
 * WC tested up to: 3.3
 * WC requires at least: 2.6
 *
 * Copyright: © 2009-2018 WooCommerce.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) ) {
    require_once( 'woo-includes/woo-functions.php' );
}

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), 'a80fbcb4d8d2822daf85442b2d647add', '18739' );

/**
 * Plugin page links
 */
function wc_gateway_anz_plugin_links( $links ) {
    $plugin_links = array(
    	'<a href="'.get_admin_url().'admin.php?page=wc-settings&tab=checkout&section=anz_egate">' . __( 'Settings', 'woocommerce-gateway-anz-egate' ) . '</a>',
        '<a href="http://support.woothemes.com/">' . __( 'Support', 'woocommerce-gateway-anz-egate' ) . '</a>',
        '<a href="http://docs.woothemes.com/document/anz-egate/">' . __( 'Docs', 'woocommerce-gateway-anz-egate' ) . '</a>',
    );
    return array_merge( $plugin_links, $links );
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_gateway_anz_plugin_links' );

/**
 * wc_gateway_anz_init function.
 */
function wc_gateway_anz_init() {
    if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
        return;
    }

    /**
     * Localisation
     */
    load_plugin_textdomain( 'woocommerce-gateway-anz-egate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    /**
     * Gateway class
     */
    class WC_Gateway_ANZ_Egate extends WC_Payment_Gateway_CC {

        /**
         * __construct function.
         *
         * @access public
         * @return void
         */
        public function __construct() {
            $this->id                 = 'anz_egate';
            $this->method_title       = __( 'ANZ eGate', 'woocommerce-gateway-anz-egate' );
            $this->method_description = __( 'ANZ eGate offers a complete payment gateway service allowing credit card processing via the internet.', 'woocommerce-gateway-anz-egate' );
            $this->icon               = apply_filters('wc_gateway_anz_egate_icon',WP_PLUGIN_URL . "/" . plugin_basename( dirname( __FILE__ ) ) . '/assets/images/cards.png', $this->id);
            $this->has_fields         = true;
            $this->supports           = array(
                //'refunds'
            );

            // Load the form fields.
            $this->init_form_fields();

            // Load the settings.
            $this->init_settings();

            // Define user set variables
            $this->access_code = $this->settings['access_code'];
            $this->title       = $this->settings['title'];
            $this->testmode    = $this->settings['testmode'];
            $this->checkoutmode = $this->settings['checkoutmode'];
            $this->description = $this->settings['description'];
            $this->merchant    = $this->settings['merchant'];
            $this->secure_hash = $this->settings['secure_hash'];
            //$this->authuser = $this->settings['authuser'];
            //$this->authpassword = $this->settings['authpassword'];
            $this->endpoint    = 'https://migs.mastercard.com.au/vpcdps';
            $this->tpendpoint  = 'https://migs.mastercard.com.au/vpcpay';

            if ( $this->testmode == 'yes' && substr( $this->merchant, 0, 4 ) !== 'TEST' ) {
                $this->merchant = 'TEST' . $this->merchant;
            }

            if ( $this->checkoutmode !== "server" ) {
                $this->supports[] = 'default_credit_card_form';
            }

            if ($this->checkoutmode == "server") {
                $this->icon = apply_filters('wc_gateway_anz_egate_icon',WP_PLUGIN_URL . "/" . plugin_basename( dirname( __FILE__ ) ) . '/assets/images/3dsecure.png', $this->id);
            }

            add_action( 'wp_head', array($this,'process_third_party_response'), 10 ); 

            add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

            add_action( 'admin_notices', array($this, 'check_for_hash_secret'), 10 );

            // Re-add the print-notices which was removed in wc commit efe06cb
            add_action('woocommerce_before_template_part',array($this,'rehook_thankyou_notices'),10,4);

        }

        /**
         * Initialise Gateway Settings Form Fields
         */
        public function init_form_fields() {
            $this->form_fields = array(
                'enabled'         => array(
                    'title'       => __( 'Enable/Disable', 'woocommerce-gateway-anz-egate' ),
                    'label'       => __( 'Enable ANZ eGate', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'checkbox',
                    'description' => '',
                    'default'     => 'no'
                ),
                'title'           => array(
                    'title'       => __( 'Title', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce-gateway-anz-egate' ),
                    'default'     => __( 'ANZ eGate', 'woocommerce-gateway-anz-egate' ),
                    'desc_tip'    => true
                ),
                'description'     => array(
                    'title'       => __( 'Description', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'text',
                    'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce-gateway-anz-egate' ),
                    'default'     => __( 'Pay with your credit card via ANZ eGate.', 'woocommerce-gateway-anz-egate' ),
                    'desc_tip'    => true
                ),
                'testmode'        => array(
                    'title'       => __( 'Test Mode', 'woocommerce-gateway-anz-egate' ),
                    'label'       => __( 'Enable Test Mode', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Place the payment gateway in development mode. The plugin automatically prefixes your Merchant ID with "TEST".', 'woocommerce-gateway-anz-egate' ),
                    'default'     => 'no',
                    'desc_tip'    => true
                ),
                'checkoutmode'        => array(
                    'title'       => __( 'Checkout Mode', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'select',
                    'description' => __( '<strong>Merchant hosted</strong> means the customer will enter their card details on your website. <strong>Server hosted</strong> means that the customer will be taken to an ANZ branded website to enter their credit card details.', 'woocommerce-gateway-anz-egate' ),
                    'options'     => array('merchant'=>'Merchant hosted','server'=>'Server hosted'),
                    'default'     => 'merchant',
                    'desc_tip'    => false
                ),
                'merchant'   => array(
                    'title'       => __( 'Merchant ID', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'text',
                    'description' => __( 'This will be provided by ANZ.', 'woocommerce-gateway-anz-egate' ),
                    'default'     => '',
                    'desc_tip'    => true
                ),
                'access_code' => array(
                    'title'       => __( 'Access Code', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'password',
                    'description' => __( 'This will be provided by ANZ.', 'woocommerce-gateway-anz-egate' ),
                    'default'     => '',
                    'desc_tip'    => true
                ),
                'secure_hash' => array(
                    'title'       => __( 'Secure Hash Secret', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'password',
                    'description' => __( 'This will be provided by ANZ.', 'woocommerce-gateway-anz-egate' ),
                    'default'     => '',
                    'desc_tip'    => true
                ),
                /*'authuser' => array(
                    'title'       => __( 'Authorised Username (optional)', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'text',
                    'description' => __( 'A username and password is only required if you wish to use the refund functionality.', 'woocommerce-gateway-anz-egate' ),
                    'default'     => '',
                    'desc_tip'    => true
                ),
                'authpassword' => array(
                    'title'       => __( 'Authorised User Password (optional)', 'woocommerce-gateway-anz-egate' ),
                    'type'        => 'password',
                    'description' => __( 'A username and password is only required if you wish to use the refund functionality.', 'woocommerce-gateway-anz-egate' ),
                    'default'     => '',
                    'desc_tip'    => true
                ), */
            );
        }

        /**
         * is_available function.
         * @return bool
         */
        public function is_available() {
            if ( "yes" === $this->enabled ) {
                if ( ! is_ssl() && $this->testmode == "no" ) {
                    return false;
                }
                // Currency check
                if ( ! in_array( get_woocommerce_currency(), array( 'AUD', 'NZD' ) ) ) {
                    return false;
                }
                // Required fields check
                if ( ! $this->access_code || ! $this->merchant ) {
                    return false;
                }
                return true;
            }
            return false;
        }

        /**
         * Payment form on checkout page
         */
        public function payment_fields() {
            if ( $this->testmode == 'yes' ) {
                $this->description .= ' ' . __( 'TEST MODE/SANDBOX ENABLED', 'woocommerce-gateway-anz-egate' );
            }
            if ( $this->description ) {
                echo wpautop( wptexturize( $this->description ) );
            }
            if ( $this->checkoutmode !== 'server') {
                $this->form();
            }
        }

        /**
         * Process the payment and return the result
         */
        public function process_payment( $order_id ) {

            $logger = wc_get_logger();
            $logcontext = array( 'source' => 'gateway-anz-egate' );    

            $order = wc_get_order( $order_id );

            $request = $this->build_request('pay',$order);

            // If this is a Server Hosted Payment (offsite)
            if ( $this->checkoutmode === "server" ) {
                $redirect = $this->tpendpoint.'?'.http_build_query( $request );
                //$logger->debug('SERVER HOSTED PAYMENT REDIRECT URL: '.$redirect,$logcontext);
                return array(
                    'result'    => 'success',
                    'redirect'  => $redirect
                );
            }

            try {
                if ( empty( $request->vpc_CardNum ) ) {
                    throw new Exception( __( 'Please enter your card number.', 'woocommerce-gateway-anz-egate' ) );
                }

                // Save last 4 digits of card number to meta
                $card_number = !empty( $_POST['anz_egate-card-number'] ) ? str_replace( array( ' ', '-' ), '', wc_clean( $_POST['anz_egate-card-number'] ) ) : '';
                $order->update_meta_data('_anz_last4',substr($card_number, -4));

                //$logger->debug('MERCHANT HOSTED PAYMENT DATA: '.http_build_query( $request ),$logcontext);

                $response = wp_remote_post( $this->endpoint, array(
                    'method'    => 'POST',
                    'body'      => http_build_query( $request ),
                    'timeout'   => 70
                ) );

                if ( is_wp_error( $response ) ) {
                    throw new Exception( __( 'There was a problem connecting to the payment gateway. '.print_r($response,true), 'woocommerce-gateway-anz-egate' ) );
                }

                if ( empty( $response['body'] ) ) {
                    throw new Exception( __( 'Empty response.', 'woocommerce-gateway-anz-egate' ) );
                }

                //$logger->debug('RESPONSE BODY: '.$response['body'],$logcontext);

                parse_str( $response['body'], $parsed_response );

                $response_code = $parsed_response['vpc_TxnResponseCode'];

                switch ( $response_code ) {
                    case "0" :
                        // Add order note
                        $order->add_order_note( sprintf( __( 'ANZ payment completed (Transaction # %s)', 'woocommerce-gateway-anz-egate' ), $parsed_response['vpc_TransactionNo'] ) );

                        // Payment complete
                        $order->payment_complete($parsed_response['vpc_TransactionNo']);

                        // Remove cart
                        wc_empty_cart();

                        // Return thank you page redirect
                        return array(
                            'result'     => 'success',
                            'redirect'   => $this->get_return_url( $order )
                        );
                    break;
                    default :
                        // Payment failed :(
                        if ($order->get_status() == "failed") {
                            $order->add_order_note( sprintf( __( 'ANZ payment failed. Payment was rejected due to an error: %s (Transaction ID: %s)', 'woocommerce-gateway-anz-egate' ), $parsed_response['vpc_Message'] , $parsed_response['vpc_TransactionNo'] ));
                        } else {
                            $order->update_status( 'failed', sprintf( __( 'ANZ payment failed. Payment was rejected due to an error: %s (Transaction ID: %s)', 'woocommerce-gateway-anz-egate' ), $parsed_response['vpc_Message'] , $parsed_response['vpc_TransactionNo'] ));    
                        }
                        $message = ( sprintf( __( 'Payment failed: %s (Transaction ID: %s)', 'woocommerce-gateway-anz-egate' ), print_r($parsed_response['vpc_Message'],true), $parsed_response['vpc_TransactionNo'] ) );
                        wc_add_notice( $message, 'error' );
                        return;
                    break;
                }
            } catch ( Exception $e ) {
                $message = sprintf( __( 'Error: %s', 'woocommerce-gateway-anz-egate' ), $e->getMessage() );
                wc_add_notice( $message, 'error' );
                return;
            }
        }

        public function build_request($action = 'pay' ,$order, $refundamount = false) {

            if ($this->checkoutmode !== 'server' && $action === 'pay') {
                $card_number    = ! empty( $_POST['anz_egate-card-number'] ) ? str_replace( array( ' ', '-' ), '', wc_clean( $_POST['anz_egate-card-number'] ) ) : '';
                $card_csc       = ! empty( $_POST['anz_egate-card-cvc'] ) ? wc_clean( $_POST['anz_egate-card-cvc'] ) : '';
                $card_expiry    = ! empty( $_POST['anz_egate-card-expiry'] ) ? wc_clean( $_POST['anz_egate-card-expiry'] ) : '';
                $card_expiry    = implode( '', array_map( 'trim', explode( '/', $card_expiry ) ) );
                if (strlen($card_expiry) == 6) {
                    $card_exp_year  = substr( $card_expiry, 4, 2 );
                } else {
                    $card_exp_year  = substr( $card_expiry, 2, 2 );    
                }
                $card_exp_month = substr( $card_expiry, 0, 2 );
            }

            $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
            $order_ref = $order_id . '-' . md5( microtime() );
            if ( strlen( $order_ref ) > 40 ) {
                $order_ref = substr( $order_ref, 0, 40 );
            }

            $request                       = new stdClass();
            $request->vpc_AccessCode       = $this->access_code;
            if ($action === 'pay') {
                $request->vpc_Amount           = $order->get_total() * 100;
            } elseif ($action === 'refund') {
                $request->vpc_Amount           = $refundamount;
            }
            
            if ($this->checkoutmode !== 'server' && $action === 'pay') {
                $request->vpc_CardExp          = $card_exp_year . $card_exp_month;
                $request->vpc_CardNum          = $card_number;
                $request->vpc_CardSecurityCode = $card_csc;
            }
            $request->vpc_Command          = $action;
            $request->vpc_Locale           = 'en';
            $request->vpc_MerchTxnRef      = $order_ref;
            $request->vpc_Merchant         = $this->merchant;
            $request->vpc_OrderInfo        = preg_replace( '/[^\da-z]/i', '', $order->get_order_number() );
            if ($this->checkoutmode === 'server' && $action === 'pay') {
                $request->vpc_ReturnURL    = $order->get_checkout_order_received_url();
            }
            
            $request->vpc_Version          = 1;

            if ($action === 'refund') {
                $request->vpc_TransactionNo = $order->get_transaction_id();
                $request->vpc_User          = $this->authuser;
                $request->vpc_Password      = $this->authpassword;
            }

            $hashinput = '';
            foreach ($request as $k => $v) {
                $hashinput .= $k."=".$v."&";
            }
            $hashinput = rtrim($hashinput,"&");
            $secure_hash = strtoupper(hash_hmac('SHA256', $hashinput, pack("H*",$this->secure_hash)));
            $request->vpc_SecureHash = $secure_hash;
            $request->vpc_SecureHashType = 'SHA256';

            return $request;
        }


        function process_third_party_response() {
            if (!isset($_GET['vpc_TxnResponseCode']) || !isset($_GET['vpc_OrderInfo'])) return;
            $order_id = $_GET['vpc_OrderInfo'];
            $order = wc_get_order($order_id);

            if (!$order) {
                $order_id = explode('-',$_GET['vpc_MerchTxnRef'])[0];
                $order = wc_get_order($order_id);
            }

            $logger = wc_get_logger();
            $logcontext = array( 'source' => 'gateway-anz-egate' );

            //$logger->debug('RESPONSE _GET: '.print_r($_GET,true),$logcontext);

            $msg = $this->get_result_description($_GET['vpc_TxnResponseCode']);

            // Was it successful?
            if ($_GET['vpc_TxnResponseCode'] === '0') {
                // Let's validate it using the secure hash
                $hashinput = '';
                foreach ($_GET as $k => $v) {
                    if (in_array($k,array('page_id','order-received','key','vpc_SecureHash','vpc_SecureHashType'))) continue;
                    $hashinput .= $k."=".$v."&";
                }
                $hashinput = rtrim($hashinput,"&");
                $secure_hash = strtoupper(hash_hmac('SHA256', $hashinput, pack("H*",$this->secure_hash)));
                
                if ($secure_hash !== $_GET['vpc_SecureHash']) {
                    // Hash doesn't match
                    $order->update_status('on-hold',sprintf(__('The secure hash returned by ANZ did not match the calculated hash. This means that the payment details may have been tampered with or faked. Confirm whether the payment was accurate and successful. Receipt # %s','woocommerce-gateway-anz-egate'),$_GET['vpc_ReceiptNo']));
                    wc_add_notice(sprintf(__('Payment successful, however we could not confirm whether this payment was legitimate. Your order has been placed on hold. (Receipt # %s)','woocommerce-gateway-anz-egate'),$_GET['vpc_ReceiptNo']),'error');
                    return;
                } else {
                    // It matches!
                    // Is the amount right?
                    if (round($order->get_total()*100) != intval($_GET['vpc_Amount'])) {
                        $logger = wc_get_logger();
                        $logcontext = array( 'source' => 'gateway-anz-egate' );
                        $logger->debug('Amount doesn\'t match. Full _GET data: '.print_r($_GET,true),$logcontext);
                        $logger->debug('Total: '.round($order->get_total()*100).' ... vpc_Amount: '.intval($_GET['vpc_Amount']),$logcontext);
                          
                        $order->update_status('on-hold',sprintf(__('The amount paid (%s) doesn\'t match the order total. Confirm whether the payment was accurate and successful. (Receipt # %s)','woocommerce-gateway-anz-egate'),wc_price($_GET['vpc_Amount']/100), $_GET['vpc_ReceiptNo']));
                        wc_add_notice(sprintf(__('Payment successful, however could not confirm whether this payment was legitimate. Your order has been placed on hold. (Receipt # %s)','woocommerce-gateway-anz-egate'),$_GET['vpc_ReceiptNo']),'error');
                        return;
                    } else {
                        // Amount is correct. Order is legit.
                        wc_add_notice($msg.' (Receipt # '.$_GET['vpc_ReceiptNo'].')','success');
                        $order->add_order_note( sprintf( __( 'ANZ payment completed (Transaction # %s)', 'woocommerce-gateway-anz-egate' ), $_GET['vpc_TransactionNo'] ) );
                        $order->payment_complete($_GET['vpc_TransactionNo']);
                        wc_empty_cart();
                        return;
                    }
                }
            } else {
                wc_add_notice('Payment Error: '.$msg.' (Receipt # '.$_GET['vpc_ReceiptNo'].')','error');
                $order->update_status( 'failed', sprintf(__('Payment attempted but failed: code %s - %s. Receipt # %s.', 'woocommerce-gateway-anz-egate'), $_GET['vpc_TxnResponseCode'], $msg, $_GET['vpc_ReceiptNo']) );
                return;
            }
            return;
        }

        function get_result_description($responseCode) {
            switch ($responseCode) {
                case "0" : $result = "Transaction Successful"; break;
                case "?" : $result = "Transaction status is unknown"; break;
                case "E" : $result = "Referred"; break;
                case "1" : $result = "Transaction Could Not Be Processed"; break;
                case "2" : $result = "Bank Declined Transaction"; break;
                case "3" : $result = "No Reply from Processing Host"; break;
                case "4" : $result = "Expired Card"; break;
                case "5" : $result = "Insufficient funds"; break;
                case "6" : $result = "Error Communicating with Bank"; break;
                case "7" : $result = "Payment Server detected an error"; break;
                case "8" : $result = "Transaction Type Not Supported"; break;
                case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
                case "A" : $result = "Transaction Aborted"; break;
                case "C" : $result = "Transaction Cancelled"; break;
                case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
                case "F" : $result = "3D Secure Authentication failed"; break;
                case "I" : $result = "Card Security Code verification failed"; break;
                case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
                case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
                case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
                case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
                case "S" : $result = "Duplicate SessionID (Amex Only)"; break;
                case "T" : $result = "Address Verification Failed"; break;
                case "U" : $result = "Card Security Code Failed"; break;
                case "V" : $result = "Address Verification and Card Security Code Failed"; break;
                default  : $result = "Unable to be determined"; 
            }
            return $result;
        }




        public function process_refund($order_id, $amount = null, $reason = '') {

            if (empty($this->authuser) || empty($this->authpassword)) {
                return new WP_Error('no_refund_auth','To process refunds you need to enter a Username and Password in the ANZ eGate gateway settings.');
            }

            $order = new WC_Order($order_id);

            $request = $this->build_request('refund',$order, $amount);

            $response = wp_remote_post( $this->endpoint, array(
                'method'    => 'POST',
                'body'      => http_build_query( $request ),
                'timeout'   => 70
            ) );

            if ( is_wp_error( $response ) ) {
                return new WP_Error('problem-connecting','There was a problem connecting to the payment gateway.');
            }

            if ( empty( $response['body'] ) ) {
                return new WP_Error('no-content','An empty response was received from ANZ.');
            }

            parse_str( $response['body'], $parsed_response );

            $response_code = $parsed_response['vpc_TxnResponseCode'];

            if ($response_code === "0") {
                // Add order note
                $order->add_order_note( sprintf( __( 'ANZ refund completed (Transaction # %s) for %s', 'woocommerce-gateway-anz-egate' ), $parsed_response['vpc_TransactionNo'], wc_price($parsed_response['vpc_Amount']) ) );
                return 1;
            } else {
                $order->add_order_note(sprintf(__('ANZ refund was NOT processed due to: %s.','woocommerce-gateway-anz-egate'),$errors));
                return 0;
            }
            return 0;
        }

        public function check_for_hash_secret() {
        	if (empty($this->secure_hash) && !empty($this->merchant)) {
        		// This is probably an upgrade and no secure hash is present
				echo '<div class="notice notice-error"><p><strong>The ANZ eGate gateway has been disabled.</strong> You must <a href="'.get_admin_url().'admin.php?page=wc-settings&tab=checkout&section='.$this->id.'">enter your Secure Hash Secret</a> provided by ANZ.</p></div>';
        	}
        }

        public function rehook_thankyou_notices($template,$path,$located,$args) {
            if ($template == 'checkout/thankyou.php') {
                wc_print_notices();
            }
        }

    }

    /**
     * wc_gateway_anz_add function.
     *
     * @access public
     * @param mixed $methods
     * @return void
     */
    function wc_gateway_anz_add( $methods ) {
        $methods[] = 'WC_Gateway_ANZ_Egate';
        return $methods;
    }
    add_filter( 'woocommerce_payment_gateways', 'wc_gateway_anz_add' );
}

add_action( 'plugins_loaded', 'wc_gateway_anz_init', 0 );


add_action('woocommerce_price_format','anz_egate_show_currency',1,2);

function anz_egate_show_currency($format,$currency_pos) {
    if (!is_checkout() && !(is_ajax() && isset($_GET['wc-ajax']) && $_GET['wc-ajax'] == 'update_order_review')) return $format;
    switch ( $currency_pos ) {
        case 'left' :
            $currency = get_woocommerce_currency();
            $format = '%1$s%2$s&nbsp;' . $currency;
        break;
    }
    return $format;
}