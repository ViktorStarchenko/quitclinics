<?php

add_action('wp_ajax_cloudcheck_send_request_heydoc', 'cloudcheck_send_request_heydoc');
add_action( 'wp_ajax_nopriv_cloudcheck_send_request_heydoc', 'cloudcheck_send_request_heydoc' ); // For anonymous users


function cloudcheck_send_request_heydoc() {
    $req = array(
        "email"=>"shavo_soad@ukr.net",
        "dob"=>"1923-1-01",
        "title"=>"Hello i think it's success",
        "first"=>"Viktor 4:45 am",
        "last"=>"Test ok?",
        "gender"=>"male",
        "phoneNumber"=>"+380971509961",
        "address"=>"123 test street",
        "city"=>"city",
        "postcode"=>"02232",
        "country"=>"AU",
        "1yrGn~WZFBQ17nwr54W7v"=>"Current/Ex-smoker",
        "0iw4CyzoA1R1jxkRdnnk9"=>"5-10",
        "TB3HclExciO9S0_uRTCLt"=>"Less than 5",
        "emDxFmHm1LidKT_L89icr"=>"Cold-Turkey",
        "ZYA6ioeD3WkrWO0PAD7lX"=>"Today",
        "Pt2wLbSjQowlAxDhQqXc1"=>"none",
        "KSW2s9naDT7hcdyY85xoj"=>"No",
        "9rorbO3lgeONaNXt3h4V2"=>"I confirm that I have read and understand the above safety information");
//
//            $arrc = json_encode($req);
////            var_dump($arrc);
    $form_data = $_POST['data'];
    $form_data = json_encode($form_data);
//            print_r($form_data);


    $curl = curl_init();
    $params = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        CURLOPT_URL => 'https://api.heydoc.co.uk/questionnaires/response/041f5aa4ca6fe55f87dddd5d3ef3915b63c0b4b7/',
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



// Add DOB field
function dob_fields( $user ) {
    ?>
    <table class="form-table">
        <tr>
            <th>Day of birth:</th>
            <td>


                <p>
                    <input
                        id="dob"
                        name="dob"
                        type="date"
                        value="<?php  echo get_user_meta($user->ID, 'dob', true); ?>"
                    />

                </p>

            </td>
        </tr>
    </table>
    <?php
}// Add DOB field
add_action( 'show_user_profile', 'dob_fields' );
add_action( 'edit_user_profile', 'dob_fields' );

// store DOB on user edit page
function dob_fields_save( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'dob', $_POST['dob'] );
}// store DOB on user edit page
add_action( 'personal_options_update', 'dob_fields_save' );
add_action( 'edit_user_profile_update', 'dob_fields_save' );

// store DOB using cloudcheck form
function cloudcheck_dob_verification() {

    if($_POST['user_id']) {
        $user = get_user_by('email', $_POST['user_id']);
        $user_id = $user->ID;
    } else {
        $user_id = get_current_user_id();
    }
    $value = $_POST['dob'];
//    $result = wp_update_user( [
//       'ID'       => $user_id,
//       'is_verified' => $value
//    ] );

    $result = update_user_meta( $user_id, 'dob', $value );

    // Получим значение поля и проверим его с новым значением $new_value
    if ( get_user_meta($user_id, 'dob', true ) != $value ) {
        $response =  array(
            "type"  => "error",
            "message" => "An error has occurred, perhaps such a user does not exist.",
        );
        echo json_encode($response);
        wp_die();

    } else {
        $response =  array(
            "type"  => "success",
            "message" => "Agreeing completed successfully.",
        );
        echo json_encode($response);
        wp_die();
    }
}// store DOB using cloudcheck form
add_action('wp_ajax_cloudcheck_dob_verification', 'cloudcheck_dob_verification');
add_action( 'wp_ajax_nopriv_cloudcheck_dob_verification', 'cloudcheck_dob_verification' ); // For anonymous users