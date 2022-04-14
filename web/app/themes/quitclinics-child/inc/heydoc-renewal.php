<?php
add_action('wp_ajax_cloudcheck_send_request_heydoc_renewal', 'cloudcheck_send_request_heydoc_renewal');
add_action( 'wp_ajax_nopriv_cloudcheck_send_request_heydoc_renewal', 'cloudcheck_send_request_heydoc_renewal' ); // For anonymous users

function cloudcheck_send_request_heydoc_renewal() {
    create_questionnaire_renewal($_POST['data']);
    save_medical_history_renewal($_POST['data']);

    send_admin_about_pregnant_email($_POST['data']);


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
function create_questionnaire_renewal($data){

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

    $first_name = $_POST['data']['first'];
    $last_name = $_POST['data']['last'];
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
            'field_622dc12760193' => $_POST['data']['dob'],

//                How long ago was your last cigarette?
            'field_622dc127601a1' => $_POST['data']['hvNck0WCKPsBb73XEzIF3'],

//                What vaping product/s have you previously used? (Please include preferred brand, nicotine strength and how much liquid you use per day)
            'field_622dc127601a0' => $_POST['data']['Jobx7PHVwKL_yumEdi7Jl'],

//                Have you had a stroke, heart attack, irregular heartbeat, uncontrolled hypertension or angina in the past month?
            'field_622dc127601a8' => $_POST['data']['qceAKDJfEDuBQj7QD1gFF'],

//                Are you pregnant, or likely to become pregnant in the next 12 months?
            'field_622dc127601a9' => $_POST['data']['3N7MEwRQQ8DyRyhUeWluZ'],

//                Your documents will be securely emailed to you, and no one else, unless you request otherwise. If you would like us to also forward your prescription to a pharmacy, supplier or friend/carer, please enter their email address.
            'field_622dc127601ab' => $_POST['data']['vk1adCeUqE8VkWvf5Qqm6'],

//                Is there anything else you would like to mention before proceeding?
            'field_622dc127601ac' => $_POST['data']['vk1adCeUqE8VkWvf5Qqm6'],

//                Safety Information and Consent
            'field_622dc127601ad' => $_POST['data']['gbHG9mDZV7bRmXggwJyYI'],




//                'field_6120da2d801b9' => $_POST['data']['evn4c1CYWy_IXe_T~a7~N'],
//                'field_6120da57801ba' => $_POST['data']['tgwN3r0X7PYP_Y2GAzCki'],
//                'field_6120db20801bc' => $_POST['data']['gXRgxbIbZgk~MiqKaDCZA'],
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


function send_admin_about_pregnant_email($data){

    $first = $data['first'];
    $last = $data['last'];
    $last = $data['last'];
    $are_you_pregnant = $data['3N7MEwRQQ8DyRyhUeWluZ'];

    if ($are_you_pregnant == 'Yes') {
        $to = 'shavo_soad@ukr.net';
        $subject = 'This user checked "Are you pregnant, or do you plan to become pregnant in the next 12 months" checkboxes';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $message = '<html><body>';


        $message .=   '<div id="m_-3357440684265998573wrapper" dir="ltr" style="min-width:620px;width:100%;box-sizing:border-box;padding:20px 0;background-color:transparent;background-image:none">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:15px">
            <tbody>
            <tr>
                <td align="center" valign="top" id="m_-3357440684265998573body_content" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background-color:transparent;background-image:none;background-size:cover">
                    <font color="#888888">
                    </font><font color="#888888">
                </font>
                    <table align="center" width="600" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border: 1px solid #afafaf;">
                        <tbody>
                        <tr>
                            <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background-repeat:no-repeat;background-size:cover;background-position:top;padding:25px 35px;background-image:none;background-color:#ffffff;border-width:0px;border-radius:0px;border-color:#444444;width:600px">
                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0">
                                    <tbody>
                                    <tr>
                                        <td valign="top" width="100%" class="m_-3357440684265998573viwec-responsive-padding" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0;font-size:0">
                                            <table align="left" width="50%" class="m_-3357440684265998573viwec-responsive" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse;width:100%">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:1.5;padding:0px;background-image:none;background-color:transparent;border-width:0px;border-radius:0px;border-color:#444444;width:265px">
                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:15px;width:265px;text-align:start;padding:0px;background-image:none">
                                                                                            <img width="140" src="https://ci4.googleusercontent.com/proxy/qx17RFm562Ij6D0KsVRSz38SOg93tJ29qk3hnLftmvkosGNe0TyNlTNzuvCH3h2jGHARlN77JXMS7WHDdUmsmNl2MbU1MvPqi2Zd7gEa4kjp7WIE0mYj=s0-d-e1-ft#https://www.quitclinics.com/app/uploads/2020/12/logo-client-logo.png" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;background-color:transparent;max-width:100%;vertical-align:middle;width:140px" class="CToWUd">
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table align="left" width="50%" class="m_-3357440684265998573viwec-responsive" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse;width:100%">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:1.5;padding:0px;background-image:none;background-color:transparent;border-width:0px;border-radius:0px;border-color:#444444;width:265px">
                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:12px;width:265px;font-weight:600;color:#332ce6;line-height:31px;text-align:right;padding:0px;background-image:none;background-color:transparent">
                                                                                            <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate;margin:0;padding:0">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td valign="top" width="33.333333333333%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFy-2BlGa4Y4tTe08GcCpm6S7T-2B8lpJB4RuGlXZLyAvM9SQ-3D-3DYieG_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqjzC978Vr4qeWFA8gdnucnTYr7YnnhR-2FCZXsw9sVO69DdHXjWkr6q6mCH6P9tqSfz5iH9e4UEIwy6O6UaZR-2FvTYD0O0DazkCyf-2BfUUEu950aGrK-2FxeDJu-2F4MlwE-2B1ppgF9lcS7DVeMFksrzRdSGi2imU-3D" style="text-decoration:none;color:#332ce6;font-weight:600;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFy-2BlGa4Y4tTe08GcCpm6S7T-2B8lpJB4RuGlXZLyAvM9SQ-3D-3DYieG_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqjzC978Vr4qeWFA8gdnucnTYr7YnnhR-2FCZXsw9sVO69DdHXjWkr6q6mCH6P9tqSfz5iH9e4UEIwy6O6UaZR-2FvTYD0O0DazkCyf-2BfUUEu950aGrK-2FxeDJu-2F4MlwE-2B1ppgF9lcS7DVeMFksrzRdSGi2imU-3D&amp;source=gmail&amp;ust=1649780566437000&amp;usg=AOvVaw2eV9MYtu-9Jo_b6fK6ce2c">
                                                                                                            How it Works                                </a>
                                                                                                    </td>
                                                                                                    <td valign="top" width="33.333333333333%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgEwzt97WsJPPbQweRdwkdaFBa-2FYIAvQVXhRdLL3dLW4Dg-3D-3Dnwfs_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj6pY2vpaJipaoybP8dbPYxdaBoI56R27o1Gi9xKeVA7sr7Hh3fM0ZdK3eFlB5-2BSpnzakJrqMPeJe73Tc3UKc4vtwveTHK7y9cXgXRq6PV45ts4HERpUTQuEk85hwl7xFk2K7GeS972mJ78E92EIJsWI-3D" style="text-decoration:none;color:#332ce6;font-weight:600;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgEwzt97WsJPPbQweRdwkdaFBa-2FYIAvQVXhRdLL3dLW4Dg-3D-3Dnwfs_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj6pY2vpaJipaoybP8dbPYxdaBoI56R27o1Gi9xKeVA7sr7Hh3fM0ZdK3eFlB5-2BSpnzakJrqMPeJe73Tc3UKc4vtwveTHK7y9cXgXRq6PV45ts4HERpUTQuEk85hwl7xFk2K7GeS972mJ78E92EIJsWI-3D&amp;source=gmail&amp;ust=1649780566437000&amp;usg=AOvVaw2AoZ9iU4vXavCxZfOYU-3m">
                                                                                                            Help &amp; Advice                                </a>
                                                                                                    </td>
                                                                                                    <td valign="top" width="33.333333333333%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgGR9HSFNSmAEoodXeag-2BUgUh7Ma_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqjwb-2BfbdrNy29-2FtUJSe-2FUz5cHXc84w4Wgyfi0hCYeTSwO-2F0OTOaiXYINAB-2Fif1OYVwgZEYWLUqS3vg0SioMTKA0SlrCrBcVgIAID9RENriLiq3-2Fpken7nEgqZ60DRqh4PYrHS9NxfPhCBfaZyPNcodIA-3D" style="text-decoration:none;color:#332ce6;font-weight:600;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgGR9HSFNSmAEoodXeag-2BUgUh7Ma_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqjwb-2BfbdrNy29-2FtUJSe-2FUz5cHXc84w4Wgyfi0hCYeTSwO-2F0OTOaiXYINAB-2Fif1OYVwgZEYWLUqS3vg0SioMTKA0SlrCrBcVgIAID9RENriLiq3-2Fpken7nEgqZ60DRqh4PYrHS9NxfPhCBfaZyPNcodIA-3D&amp;source=gmail&amp;ust=1649780566437000&amp;usg=AOvVaw2DECZ-H3uAaxpVad7YzKrA">
                                                                                                            Knowledge                                </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background-repeat:no-repeat;background-size:cover;background-position:top;padding:0px;background-image:none;background-color:#ffffff;border-width:0px;border-radius:0px;border-color:#444444;width:600px">
                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0">
                                    <tbody>
                                    <tr>
                                        <td valign="top" width="100%" class="m_-3357440684265998573viwec-responsive-padding" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0;font-size:0">
                                            <table align="left" width="100%" class="m_-3357440684265998573viwec-responsive" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse;width:100%">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:1.5;padding:0px;background-image:none;background-color:transparent;border-width:0px;border-radius:0px;border-color:#444444;width:600px">
                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:15px;width:600px">
                                                                                            <div id="m_-3357440684265998573viwec-transferred-content">

                                                                                                    <div id=":5n8" class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q" role="button" tabindex="0" aria-label="Download attachment " data-tooltip-class="a1V" data-tooltip="Download">
                                                                                                        <div class="akn">
                                                                                                            <div class="aSK J-J5-Ji aYr"></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                </p>
                                                                                                <p style="display:block;margin:0;font-size:15px;font-weight:400;line-height:22px;color:#444444;background-color:transparent;margin-top:25px;margin-bottom:25px;text-align:center;padding:0 35px">User '. $first .' '. $last .'  checked next: <span style="display: block;text-align: left;width: 80%">"Are you pregnant, or do you plan to become pregnant in the next 12 months?" : '.$are_you_pregnant.'</span></p>

                                                                                                <img src="https://ci3.googleusercontent.com/proxy/VEU7keb9J3JVUoVooFKN--sJ9ni30JKqJmZoka3Ce_HjjLy0dxkBlJmfUSwe_fWb0Bl9kkXsoXvdZPmdgyWGR7PSzgqaxCubSFn5ob72oT95seNqAq5iCwUWUeldB94VT8Hca-omkwdOtkxeCfkpbdFoHKR-XGfhSs-EyT6IOPZhpEZzWyI03FMKQ39dolDiCFqbRgOtc6Z60bc=s0-d-e1-ft#https://www.quitclinics.com/wp?data=b2lkPTEwMzIyJmVpZD0yMDA5NjImdXNlcl9lbWFpbD12aWt0b3Iuc0BvdmVyZG9zZS5kaWdpdGFsJnVzZXJfaWQ9OTY&amp;fuepx=1" height="1" width="1" style="line-height:100%;outline:none;background-color:transparent;padding-right:8px;border:none;font-size:14px;font-weight:bold;height:auto;text-decoration:none;text-transform:capitalize;vertical-align:middle;margin-right:10px;max-width:100%" class="CToWUd">
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background-repeat:no-repeat;background-size:cover;background-position:top;padding:45px 35px;background-image:none;background-color:#ffffff;border-width:0px;border-radius:0px;border-color:#444444;width:600px">
                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0">
                                    <tbody>
                                    <tr>
                                        <td valign="top" width="100%" class="m_-3357440684265998573viwec-responsive-padding" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0;font-size:0">
                                            <table align="left" width="50%" class="m_-3357440684265998573viwec-responsive" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse;width:100%">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:1.5;padding:0px;background-image:none;background-color:transparent;border-width:0px;border-radius:0px;border-color:#444444;width:265px">
                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:15px;width:265px;text-align:start;padding:0px 0px 20px;background-image:none;background-color:transparent">
                                                                                            <img width="140" src="https://ci4.googleusercontent.com/proxy/qx17RFm562Ij6D0KsVRSz38SOg93tJ29qk3hnLftmvkosGNe0TyNlTNzuvCH3h2jGHARlN77JXMS7WHDdUmsmNl2MbU1MvPqi2Zd7gEa4kjp7WIE0mYj=s0-d-e1-ft#https://www.quitclinics.com/app/uploads/2020/12/logo-client-logo.png" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;background-color:transparent;max-width:100%;vertical-align:middle;width:140px" class="CToWUd">
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:15px;width:265px;line-height:22px;background-image:none;background-color:transparent;padding:0px;border-width:0px;border-radius:0px;border-color:#444444">
                                                                                            <p style="display:block;font-size:inherit;margin:0px;padding:0px;border:0px;line-height:inherit;font-family:DMSans;vertical-align:baseline;color:#8c8c8c;letter-spacing:0.3px"><span style="margin:0px;padding:0px;border:0px;font:inherit;vertical-align:baseline;color:#332ce6">802-808 Pacific Highway</span><br style="margin:0px;padding:0px"><span style="margin:0px;padding:0px;border:0px;font:inherit;vertical-align:baseline;color:#332ce6">Gordon NSW 2072</span></p>
                                                                                            <p style="display:block;font-size:inherit;margin:0px;padding:0px;border:0px;line-height:inherit;font-family:DMSans;vertical-align:baseline;color:#8c8c8c;letter-spacing:0.3px">&nbsp;</p>
                                                                                            <p style="display:block;font-size:inherit;margin:0px;padding:0px;border:0px;line-height:inherit;font-family:DMSans;vertical-align:baseline;color:#8c8c8c;letter-spacing:0.3px"><span style="margin:0px;padding:0px;border:0px;font:inherit;vertical-align:baseline;color:#332ce6"><a href="mailto:info@quitclinics.com" style="text-decoration:none;margin:0px;padding:0px;border:0px;font-style:inherit;font-variant:inherit;font-weight:bold;font-size:inherit;line-height:inherit;font-family:inherit;vertical-align:baseline;color:#332ce6" target="_blank">info@quitclinics.com</a></span></p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <table align="left" width="50%" class="m_-3357440684265998573viwec-responsive" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse;width:100%">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:1.5;padding:0px;background-image:none;background-color:transparent;border-width:0px;border-radius:0px;border-color:#444444;width:265px">
                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:16px;width:265px;font-weight:600;color:#332ce6;line-height:40px;text-align:right;padding:0px;background-image:none;background-color:transparent">
                                                                                            <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate;margin:0;padding:0">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFy-2BlGa4Y4tTe08GcCpm6S7T-2B8lpJB4RuGlXZLyAvM9SQ-3D-3Dbcx7_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj-2FnpMxiJnZxop8mt00-2F45QNNOCAPBPDoQVKsVKTbapJScIyg-2FbgHMAmT5Z3h1k1JHh2DfUx2oJtqIJViOcXgOf4sbpOgX0-2B0fRH6u14FIfnuIkoRNO-2FJzBufArHG-2F3ccw-2B5kJc-2FVpJGCp5pu3S6JUO0-3D" style="text-decoration:none;color:#332ce6;font-weight:600;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFy-2BlGa4Y4tTe08GcCpm6S7T-2B8lpJB4RuGlXZLyAvM9SQ-3D-3Dbcx7_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj-2FnpMxiJnZxop8mt00-2F45QNNOCAPBPDoQVKsVKTbapJScIyg-2FbgHMAmT5Z3h1k1JHh2DfUx2oJtqIJViOcXgOf4sbpOgX0-2B0fRH6u14FIfnuIkoRNO-2FJzBufArHG-2F3ccw-2B5kJc-2FVpJGCp5pu3S6JUO0-3D&amp;source=gmail&amp;ust=1649780566437000&amp;usg=AOvVaw07LvuU5T0Hag9GjZckjfCJ">
                                                                                                            How it Works                                </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgEwzt97WsJPPbQweRdwkdaFBa-2FYIAvQVXhRdLL3dLW4Dg-3D-3Dear2_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj4xkQSO8qHbca3xp7WheRcZnCH-2B0nr1EyuG2ZHBR3IyWArkjvz1zJWwfOfRYstwo16L5hqiNTwUrMCWiXSccDWHIa3hrDIarr5bb6dF-2B7ukTMshgyHvnQYxhGUEshJgwustdEKOEDPDXN8RFLJGAWGU-3D" style="text-decoration:none;color:#332ce6;font-weight:600;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgEwzt97WsJPPbQweRdwkdaFBa-2FYIAvQVXhRdLL3dLW4Dg-3D-3Dear2_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj4xkQSO8qHbca3xp7WheRcZnCH-2B0nr1EyuG2ZHBR3IyWArkjvz1zJWwfOfRYstwo16L5hqiNTwUrMCWiXSccDWHIa3hrDIarr5bb6dF-2B7ukTMshgyHvnQYxhGUEshJgwustdEKOEDPDXN8RFLJGAWGU-3D&amp;source=gmail&amp;ust=1649780566437000&amp;usg=AOvVaw32CIosjN_bW7UpH5lZYb4s">
                                                                                                            Help &amp; Advice                                </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgGR9HSFNSmAEoodXeag-2BUgUC08P_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj-2FrsXWdOA-2BT7OpIPQa9VHxxxYzGpb6W5uf1huokS8v13-2FvN8VxbzFSKlJ8XrOIRKOxl1hs-2FpulkroFewACPH-2BY5csXsp5LFvlVI4B7T0TMfNPs4pE74aWnlQk65tEAyzNc35D-2Fm2j-2Bxf2CbaFS5mC7g-3D" style="text-decoration:none;color:#332ce6;font-weight:600;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgGR9HSFNSmAEoodXeag-2BUgUC08P_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj-2FrsXWdOA-2BT7OpIPQa9VHxxxYzGpb6W5uf1huokS8v13-2FvN8VxbzFSKlJ8XrOIRKOxl1hs-2FpulkroFewACPH-2BY5csXsp5LFvlVI4B7T0TMfNPs4pE74aWnlQk65tEAyzNc35D-2Fm2j-2Bxf2CbaFS5mC7g-3D&amp;source=gmail&amp;ust=1649780566437000&amp;usg=AOvVaw2BF07Xh_pl9jtAbPXcE8-p">
                                                                                                            Knowledge                                </a>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;background-repeat:no-repeat;background-size:cover;background-position:top;padding:15px 35px;background-image:none;background-color:#ffffff;border-width:1px 0px;border-radius:0px;border-color:#afafaf;width:600px;border-style:solid">
                                <font color="#888888">
                                </font>
                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0">
                                    <tbody>
                                    <tr>
                                        <td valign="top" width="100%" class="m_-3357440684265998573viwec-responsive-padding" border="0" cellpadding="0" cellspacing="0" style="width:100%;font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;border-collapse:collapse;margin:0;padding:0;font-size:0">
                                            <font color="#888888">
                                            </font>
                                            <table align="left" width="50%" class="m_-3357440684265998573viwec-responsive" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse">
                                                <tbody>
                                                <tr>
                                                    <td style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                        <font color="#888888">
                                                        </font>
                                                        <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse;width:100%">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:1.5;padding:0px;background-image:none;background-color:transparent;border-width:0px;border-radius:0px;border-color:#444444;width:265px">
                                                                    <font color="#888888">
                                                                    </font>
                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                <font color="#888888">
                                                                                </font>
                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:12px;width:265px;font-weight:400;color:#332ce6;line-height:22px;text-align:start;padding:0px;background-image:none">
                                                                                            <font color="#888888">
                                                                                            </font>
                                                                                            <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate;margin:0;padding:0">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td valign="top" width="50%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFfmUtEUDbxUu0HDLQenIhSF46cvJTO11dqZt6Omc0nQQ-3D-3DyhZp_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj47HEC4RPCIWRSJ7ignJn4Oc1MnwqtRpTyZc6gycyvXrvRgG5riYwvXDRhEGDjHWUn-2BexgP5bCMutAexmEuUi7QvkwSB-2Fo1UF2EFffGxWw57x60ye8b5SNzb3EnJuk72kDEb1XUxkGz1sXajvFe-2B7WQ-3D" style="text-decoration:none;color:#332ce6;font-weight:400;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFfmUtEUDbxUu0HDLQenIhSF46cvJTO11dqZt6Omc0nQQ-3D-3DyhZp_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj47HEC4RPCIWRSJ7ignJn4Oc1MnwqtRpTyZc6gycyvXrvRgG5riYwvXDRhEGDjHWUn-2BexgP5bCMutAexmEuUi7QvkwSB-2Fo1UF2EFffGxWw57x60ye8b5SNzb3EnJuk72kDEb1XUxkGz1sXajvFe-2B7WQ-3D&amp;source=gmail&amp;ust=1649780566438000&amp;usg=AOvVaw0DOt4nk7zypdn33TU-S_Hd">
                                                                                                            Terms &amp; Conditions                                </a>
                                                                                                    </td>
                                                                                                    <td valign="top" width="50%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                        <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFQHN0rh7NCgp-2Bx0BFynoDLRN1tmXK0qRMzYtW7V9ISrw-3D-3Dov4I_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj03PBIcqT23Mw9Il5pBcYhFfBK79T1N6aXp8zIDSj1weY9cJNrWo0paU9BZQ1KY-2Fnc3mS-2BZCQhXcHCSr3PiSzTrpHywBE2XsVmE-2BtsD-2Blk94lGfR8aHFb-2FK5zq8Gi9hgsTdeC-2BzEvVkcwnDkEIdAmL8-3D" style="text-decoration:none;color:#332ce6;font-weight:400;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgFQHN0rh7NCgp-2Bx0BFynoDLRN1tmXK0qRMzYtW7V9ISrw-3D-3Dov4I_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj03PBIcqT23Mw9Il5pBcYhFfBK79T1N6aXp8zIDSj1weY9cJNrWo0paU9BZQ1KY-2Fnc3mS-2BZCQhXcHCSr3PiSzTrpHywBE2XsVmE-2BtsD-2Blk94lGfR8aHFb-2FK5zq8Gi9hgsTdeC-2BzEvVkcwnDkEIdAmL8-3D&amp;source=gmail&amp;ust=1649780566438000&amp;usg=AOvVaw1chDoLja3n2p5rBDCrO6ga">
                                                                                                            Privacy Policy                                </a><font color="#888888">
                                                                                                    </font>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <font color="#888888">
                                                                                            </font>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <font color="#888888">
                                                                                </font>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <font color="#888888">
                                                                    </font>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <font color="#888888">
                                                        </font>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <font color="#888888">
                                                <table align="left" width="50%" class="m_-3357440684265998573viwec-responsive" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse">
                                                    <tbody>
                                                    <tr>
                                                        <td style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                            <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;margin:0;padding:0;border-collapse:collapse;width:100%">
                                                                <tbody>
                                                                <tr>
                                                                    <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;line-height:1.5;padding:0px;background-image:none;background-color:transparent;border-width:0px;border-radius:0px;border-color:#444444;width:265px">
                                                                        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td valign="top" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-size:12px;width:265px;font-weight:400;color:#332ce6;line-height:22px;text-align:right;padding:0px;background-image:none">
                                                                                                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-collapse:separate;margin:0;padding:0">
                                                                                                    <tbody>
                                                                                                    <tr>
                                                                                                        <td valign="top" width="100%" style="font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif">
                                                                                                            <a href="http://url6320.quitclinics.com/ls/click?upn=AlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgHVgLCVqxjqkPCHQw701tjWZIGS_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj74vqQXtcpAh3EmLAg8enjZaW1T9sgyD4ryfttBYJqB0qDbB54kFWZNT7e-2FP24327b9C6EEGvWbJTN-2FHuybHO5eETXXQhWVthd-2Bidpw-2FLbQGk9xY5b6FytreU43Is-2Fy-2B-2BNUid-2BbyAxpZDef9ekCNj1c-3D" style="text-decoration:none;color:#332ce6;font-weight:400;font-style:inherit" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://url6320.quitclinics.com/ls/click?upn%3DAlIsBql7hm-2FByLXMc88nmUCk-2BflDybVS1MYo9E3ZpgHVgLCVqxjqkPCHQw701tjWZIGS_rzp0vXOhEYP3KwOacdcFcIPmxlYd7p-2BvUBBFoc2P4OJpPZHgHMJ8pUFR33t7Rd-2BwZNOVOlCNYlQAetiZU-2BEqj74vqQXtcpAh3EmLAg8enjZaW1T9sgyD4ryfttBYJqB0qDbB54kFWZNT7e-2FP24327b9C6EEGvWbJTN-2FHuybHO5eETXXQhWVthd-2Bidpw-2FLbQGk9xY5b6FytreU43Is-2Fy-2B-2BNUid-2BbyAxpZDef9ekCNj1c-3D&amp;source=gmail&amp;ust=1649780566438000&amp;usg=AOvVaw0v98g-77XQr2ZLrIcqcbIi">
                                                                                                                Quitclinics                                </a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </font>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <font color="#888888">
                                </font>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <font color="#888888">
                    </font>
                </td>
            </tr>
            </tbody>
        </table>
        <font color="#888888">
        </font>
    </div>
</body>
</html>';
        $message .= '</body></html>';



        wp_mail($to, $subject, $message, $headers );
    }


}