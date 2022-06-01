<?php
add_action('wp_ajax_cloudcheck_send_request_heydoc_renewal', 'cloudcheck_send_request_heydoc_renewal');
add_action( 'wp_ajax_nopriv_cloudcheck_send_request_heydoc_renewal', 'cloudcheck_send_request_heydoc_renewal' ); // For anonymous users

function cloudcheck_send_request_heydoc_renewal() {
    create_questionnaire_renewal($_POST['data']);
    save_medical_history_renewal($_POST['data']);

    send_admin_about_pregnant_email_renewal($_POST['data']);


    $form_data = $_POST['data'];
    $form_data = json_encode($form_data);

    $curl = curl_init();
    $params = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        CURLOPT_URL => 'https://api.heydoc.co.uk/questionnaires/response/8ecd2c0a3bb5bffa429b3df41d2caba640fdf9e3/',
        CURLOPT_PORT => 443,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_VERBOSE => 1,
        CURLOPT_POSTFIELDS => $form_data,
    );
    curl_setopt_array($curl, $params);
    $result = null;
    try {
        $result = curl_exec($curl);
        echo $result;
        if (!$result) {
            $errno = curl_errno($curl);
            $error = curl_error($curl);
            error_log($error);
            echo $error;
        }
        curl_close($curl);
    } catch (HttpException $ex) {
        error_log($ex);
        echo $ex;
    }
    wp_die();

}



/*
 *
 * Register Questionnaire post type
 *
 */
function questionnaire_renewal_custom_post_type() {
    register_post_type('questionnaire_renew', array(
        'public' => true,
        'labels' => array(
            'name' => __( 'Questionnaires Renewal' ),
            'singular_name' => __( 'Questionnaire Renewal' )
        ),
        'public' => true,
        'supports'  => array( 'title', 'author', 'custom-fields'),
    ));
}
add_action('init','questionnaire_renewal_custom_post_type');



/*
 *
 * Create Questionnaire post
 *
 */
function create_questionnaire_renewal($args){

    $data = $args;
    if ( is_user_logged_in() ) {
        $current_user_id = get_current_user_id();
        $current_user = wp_get_current_user();
        $user_login = $current_user->user_login;
        $user_email = $current_user->user_email;
        $user_first_name = $current_user->first_name;
        $user_last_name = $current_user->last_name;
        $is_logged = true;
        $category = get_cat_ID( 'logged' );
    } else {
        $user_login = '';
        $user_email = '';
        $user_first_name = '';
        $user_last_name = '';
        $is_logged = false;
        $category = get_cat_ID( 'unlogged' );
    }

    $date = date_create();
    $date = date_timestamp_get($date);

    $first_name = $data['first'];
    $last_name = $data['last'];
    $title = '#' . $date . '-' . $first_name . ' ' . $last_name;
    $slug = sanitize_title($title);

    $submition_time = date("M d Y h:i:s A");

    $exisiting_questionnaire = get_page_by_path($slug, 'OBJECT', 'questionnaire_renew'); //ADD POST SLUG
    if ($exisiting_questionnaire === NULL) { //IF WE NOT HAVE CREATED POST WITH THIS SLUG - CREATE NEW POST


        $insterted_questionnaire = wp_insert_post([ //CREATE NEW POSTS
            'post_name' => $slug,
            'post_title' => $title,
            'post_type' => 'questionnaire_renew',
            'post_status' => 'draft',
            'post_category' => array('logged')
        ]);
        //THE ACF PART
        $field_key = 'field_622dc12760186'; //key for acf group
        $values = array(
            'field_622dc12760188' => $is_logged,
            'field_622dc12760189' => $user_login,
            'field_622dc1276018c' => $user_email,
            'field_622dc1276018a' => $user_first_name,
            'field_622dc1276018b' => $user_last_name,
            'field_622dc12760190' => $submition_time,


            'field_622dc12760191' => $first_name,
            'field_622dc12760192' => $last_name,
            'field_622dc12760193' => $data['dob'],

//                How long ago was your last cigarette?
            'field_622dc127601a1' => $data['hvNck0WCKPsBb73XEzIF3'],

//                What vaping product/s have you previously used? (Please include preferred brand, nicotine strength and how much liquid you use per day)
            'field_622dc127601a0' => $data['Jobx7PHVwKL_yumEdi7Jl'],

//                Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?
            'field_622dc127601a8' => $data['qceAKDJfEDuBQj7QD1gFF'],

//                Are you pregnant, or likely to become pregnant in the next 12 months?
            'field_622dc127601a9' => $data['3N7MEwRQQ8DyRyhUeWluZ'],

//                Your documents will be securely emailed to you, and no one else, unless you request otherwise. If you would like us to also forward your prescription to a pharmacy, supplier or friend/carer, please enter their email address.
            'field_622dc127601ab' => $data['vk1adCeUqE8VkWvf5Qqm6'],

//                Is there anything else you would like to mention before proceeding?
            'field_622dc127601ac' => $data['vk1adCeUqE8VkWvf5Qqm6'],

//                Safety Information and Consent
            'field_622dc127601ad' => $data['gbHG9mDZV7bRmXggwJyYI'],

        );
        update_field( $field_key, $values, $insterted_questionnaire );

    } else {
        $exisiting_questionnaire_id = $exisiting_event->ID;

        $field_key = 'field_622dc12760186'; //key for acf group
        $values = array(
            'field_622dc12760188' => $is_logged,
            'field_622dc12760189' => $user_login,
            'field_622dc1276018c' => $user_email,
            'field_622dc1276018a' => $user_first_name,
            'field_622dc1276018b' => $user_last_name,

            'field_622dc12760190' => $submition_time,
            'field_622dccc9d5b58' => 'Something went wrong',

        );
        update_field( $field_key, $values, $insterted_questionnaire );

    }
}


/***
 *** Save Medical History
 ***/

function save_medical_history_renewal($data) {

    $user_id = get_current_user_id();
    $submition_time = date("F j, Y, g:i a");
    update_user_meta( $user_id, 'last_history_update', $submition_time );
    update_user_meta( $user_id, 'first', $data['first'] );
    update_user_meta( $user_id, 'last', $data['last'] );
    update_user_meta( $user_id, 'additional_dob', $data['dob'] );
    update_user_meta( $user_id, 'last_cigarette', $data['hvNck0WCKPsBb73XEzIF3'] );
    update_user_meta( $user_id, 'vaping_product', $data['Jobx7PHVwKL_yumEdi7Jl'] );
    update_user_meta( $user_id, 'heart_attack', $data['qceAKDJfEDuBQj7QD1gFF'] );
    update_user_meta( $user_id, 'are_you_pregnant', $data['3N7MEwRQQ8DyRyhUeWluZ'] );
    update_user_meta( $user_id, 'special_requirements', $data['vk1adCeUqE8VkWvf5Qqm6'] );
    update_user_meta( $user_id, 'emaile_documents', $data['B90LYTslk__msuLzLkQ31'] );
    update_user_meta( $user_id, 'confirm_safety_information', $data['gbHG9mDZV7bRmXggwJyYI'] );

}



add_action('woocommerce_thankyou', 'save_medical_history_renewal_after_order_created', 10, 1);

function save_medical_history_renewal_after_order_created($order_id) {

    $order = wc_get_order( $order_id );

    $form_data = array(
        'first' => get_user_meta($order->customer_id, 'first', true),
        'last' => get_user_meta($order->customer_id, 'last', true),
        'dob' => get_user_meta($order->customer_id, 'additional_dob', true),
        'hvNck0WCKPsBb73XEzIF3' => get_user_meta($order->customer_id, 'last_cigarette', true),
        'Jobx7PHVwKL_yumEdi7Jl' => get_user_meta($order->customer_id, 'vaping_product', true),
        'qceAKDJfEDuBQj7QD1gFF' => get_user_meta($order->customer_id, 'heart_attack', true),
        '3N7MEwRQQ8DyRyhUeWluZ' => get_user_meta($order->customer_id, 'are_you_pregnant', true),
        'vk1adCeUqE8VkWvf5Qqm6' => get_user_meta($order->customer_id, 'special_requirements', true),
        'B90LYTslk__msuLzLkQ31' => get_user_meta($order->customer_id, 'emaile_documents', true),
        'gbHG9mDZV7bRmXggwJyYI' => get_user_meta($order->customer_id, 'confirm_safety_information', true)
    );

    create_questionnaire_renewal($form_data);

    
    $form_data = json_encode($form_data);

    $curl = curl_init();
    $params = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        CURLOPT_URL => 'https://api.heydoc.co.uk/questionnaires/response/8ecd2c0a3bb5bffa429b3df41d2caba640fdf9e3/',
        CURLOPT_PORT => 443,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_VERBOSE => 1,
        CURLOPT_POSTFIELDS => $form_data,
    );
    curl_setopt_array($curl, $params);
    $result = null;
    try {
        $result = curl_exec($curl);
        echo $result;
        if (!$result) {
            $errno = curl_errno($curl);
            $error = curl_error($curl);
            error_log($error);
            echo $error;
        }
        curl_close($curl);
    } catch (HttpException $ex) {
        error_log($ex);
        echo $ex;
    }
    var_dump($ex);

}


function send_admin_about_pregnant_email_renewal($data){
    $date = date('Y-m-d H:i:s');
//    $date = date_timestamp_get($date);
    $first = $data['first'];
    $last = $data['last'];
    $are_you_pregnant_renewal = $data['3N7MEwRQQ8DyRyhUeWluZ'];
    $are_you_pregnant_initial = $data['6zudIdCy1XEoCX8Sw0NgK'];
    $has_heart_attack_renewal = $data['qceAKDJfEDuBQj7QD1gFF'];
    $has_heart_attack_initial = $data['65oh_cXb82k9FFSQTpnCq'];

    $args = array(
        'date' => $date,
        'first' => $first,
        'last' => $last,
        'are_you_pregnant_renewal' => '-',
        'are_you_pregnant_initial' => '-',
        'date' => $date,
        'has_heart_attack_renewal' => '-',
        'has_heart_attack_initial' => '-'
    );

    if ($are_you_pregnant_renewal == 'Yes') {
        $args['are_you_pregnant_renewal'] = $are_you_pregnant_renewal;

    }if ($are_you_pregnant_initial == 'Yes') {
        $args['are_you_pregnant_initial'] = $are_you_pregnant_initial;
    }
    if ($has_heart_attack_renewal == 'Yes') {
        $args['has_heart_attack_renewal'] = $has_heart_attack_renewal;

    }if ($has_heart_attack_initial == 'Yes') {
        $args['has_heart_attack_initial'] = $has_heart_attack_initial;
    }

    $admin_email = get_option('admin_email');
    if ($are_you_pregnant_renewal == 'Yes' or $are_you_pregnant_initial == 'Yes' or $has_heart_attack_initial == 'Yes' or $has_heart_attack_renewal == 'Yes') {

        $recipient = '';
        $recipient = get_field('email_recipient', 1204);
        $to = explode( ',', $recipient );
        array_push($to, $admin_email);

        $subject = 'User ' . $first . ' ' . $last . '  checked "Are you pregnant... , or Has heart attack..." checkboxes';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $message = get_notice_pregnant_email_template ($args);

        wp_mail($to, $subject, $message, $headers );
    }

}