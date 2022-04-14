<?php

add_action('wp_ajax_cloudcheck_send_request_heydoc', 'cloudcheck_send_request_heydoc');
add_action( 'wp_ajax_nopriv_cloudcheck_send_request_heydoc', 'cloudcheck_send_request_heydoc' ); // For anonymous users

function cloudcheck_send_request_heydoc() {
    create_questionnaire($_POST['data']);
    save_medical_history($_POST['data']);

    $form_data = $_POST['data'];
    $form_data = json_encode($form_data);

    $curl = curl_init();
    $params = array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        CURLOPT_URL => 'https://api.heydoc.co.uk/questionnaires/response/9f76add10c13413c3517953682e891613c6163a6/',
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



/***
 *** Save Medical History
 ***/

function save_medical_history($data) {

    $user_id = get_current_user_id();
    $submition_time = date("F j, Y, g:i a");
    update_user_meta( $user_id, 'last_history_update', $submition_time );
    update_user_meta( $user_id, 'first', $data['first'] );
    update_user_meta( $user_id, 'last', $data['last'] );
    update_user_meta( $user_id, 'additional_dob', $data['dob'] );
    update_user_meta( $user_id, 'last_cigarette', $data['nkgg3ZZPoWhDuMqRFuab5'] );
//    update_user_meta( $user_id, 'vaping_product', $data['Jobx7PHVwKL_yumEdi7Jl'] );
    update_user_meta( $user_id, 'heart_attack', $data['65oh_cXb82k9FFSQTpnCq'] );
    update_user_meta( $user_id, 'are_you_pregnant', $data['6zudIdCy1XEoCX8Sw0NgK'] );
    update_user_meta( $user_id, 'special_requirements', $data['JerSYpGMeTg~Z75luZ72Q'] );
    update_user_meta( $user_id, 'emaile_documents', $data['edtL2L2EgXHeafjrROWeR'] );
    update_user_meta( $user_id, 'confirm_safety_information', $data['t9SgLNeqhCd2TkecatA8s'] );

}


/*
 *
 * Register Questionnaire post type
 *
 */
 function questionnaire_custom_post_type() {
            register_post_type('questionnaire', array(
                'public' => true,
                'labels' => array(
                    'name' => __( 'Questionnaires' ),
                    'singular_name' => __( 'Questionnaire' )
                ),
                'public' => true,
                'supports'  => array( 'title', 'author', 'custom-fields'),
            ));
        }
 add_action('init','questionnaire_custom_post_type');



/*
 *
 * Create Questionnaire post
 *
 */
function create_questionnaire($data){

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

        $exisiting_questionnaire = get_page_by_path($slug, 'OBJECT', 'questionnaire'); //ADD POST SLUG
        if ($exisiting_questionnaire === NULL) { //IF WE NOT HAVE CREATED POST WITH THIS SLUG - CREATE NEW POST


            $insterted_questionnaire = wp_insert_post([ //CREATE NEW POSTS
                'post_name' => $slug,
                'post_title' => $title,
                'post_type' => 'questionnaire',
                'post_status' => 'draft',
                'post_category' => array('logged')
            ]);
            //THE ACF PART
            $field_key = 'field_6120bd056d96c'; //key for acf group
            $values = array(
                'field_6120fab00c2a5' => $is_logged,
                'field_6120f986eb1f5' => $user_login,
                'field_6120f9a5eb1f7' => $user_email,
                'field_6120f98beb1f6' => $user_first_name,
                'field_6120fc2936e7d' => $user_last_name,
                'field_612100901216d' => $submition_time,
                'field_61f84525b56ee' => $_POST['data']['product_name'],
                'field_61f84551b56ef' => $_POST['data']['product_id'],


                'field_6120bd266d96d' => $first_name,
                'field_6120bd4a76f0c' => $last_name,
                'field_6120bd5176f0d' => $_POST['data']['dob'],
                'field_6120bd5c76f0e' => $_POST['data']['email'],
                'field_6120bd6c76f0f' => $_POST['data']['address'],
                'field_6120bd8176f10' => $_POST['data']['city'],
                'field_6120bd8976f11' => $_POST['data']['postcode'],
                'field_6120bd8f76f12' => $_POST['data']['country'],
                'field_6120bd9876f13' => $_POST['data']['phoneNumber'],
                'field_6120bda776f14' => $_POST['data']['gender'],

                'field_61e31933a03b9' => $_POST['data']['3hC7sLm3JSsfqiM0ulcX8'],

//                Smoking History
                'field_6120bdce76f15' => $_POST['data']['_43BE13FsOc866RqRYOQ4'],
                'field_6120bdd276f16' => $_POST['data']['rRPAX~NegkGzMk1axpM4p'],
                'field_6120bdda76f17' => $_POST['data']['BCy65jqX6Q1FJN1rePAZ4'],
                'field_6120bde076f18' => $_POST['data']['nkgg3ZZPoWhDuMqRFuab5'],

//                Vaping History
                'field_61e312cad6511' => $_POST['data']['DWwVhzdpzYV_S6W_Pzf5V'],
                'field_61e31326535cb' => $_POST['data']['~VAv~puUguY76Lr9hHok5'],
                'field_61e314027dca4' => $_POST['data']['laot2_3JF6ZVIanoQCxaM'],
                'field_61e3143bdd1a3' => $_POST['data']['l7pGmBv8777ub~PaQta0P'],
                'field_61e31468c226a' => $_POST['data']['~NS42HF~cIVNIW8bohuFE'],

//                Medical History
                'field_6120bde976f19' => $_POST['data']['Qg7XDz8NOIM1oShkyViot'],
                'field_6120bdf476f1a' => $_POST['data']['65oh_cXb82k9FFSQTpnCq'],
                'field_6120daf6801bb' => $_POST['data']['6zudIdCy1XEoCX8Sw0NgK'],

                //Final Questions
                'field_61e3152bf6e3f' => $_POST['data']['edtL2L2EgXHeafjrROWeR'],
                'field_61e31562f6e40' => $_POST['data']['JerSYpGMeTg~Z75luZ72Q'],
                'field_6120bdfb76f1b' => $_POST['data']['t9SgLNeqhCd2TkecatA8s'],


//                'field_6120da2d801b9' => $_POST['data']['evn4c1CYWy_IXe_T~a7~N'],
//                'field_6120da57801ba' => $_POST['data']['tgwN3r0X7PYP_Y2GAzCki'],
//                'field_6120db20801bc' => $_POST['data']['gXRgxbIbZgk~MiqKaDCZA'],
            );
            update_field( $field_key, $values, $insterted_questionnaire );

        } else {
            $exisiting_questionnaire_id = $exisiting_event->ID;

            $field_key = 'field_6120bd056d96c'; //key for acf group
            $values = array(
                'field_6120fab00c2a5' => $is_logged,
                'field_6120f986eb1f5' => $user_login,
                'field_6120f9a5eb1f7' => $user_email,
                'field_6120f98beb1f6' => $user_first_name,
                'field_6120fc2936e7d' => $user_last_name,

                'field_612100901216d' => $submition_time,
                'field_6120bd266d96d' => 'Something went wrong',

            );
            update_field( $field_key, $values, $insterted_questionnaire );

        }
}


//add_action('admin_init', 'questionnaire_set_to_draft' );
function questionnaire_set_to_draft() {

    $args =  array(
        'post_type' => 'questionnaire',
        'posts_per_page' => 100,
        'order'          => 'ASC',
        'post_status' => 'publish'
    );
    $slider_posts = get_posts( $args );

    foreach ( $slider_posts as $slide ) {
//        var_dump($slide->ID);
        $post = array( 'ID' => $slide->ID, 'post_status' => 'draft' );
        wp_update_post($post);
    }
}


/*** Save medical history fields after register new user if questionnaire was submitted ***/

/***  ***/

add_action('wp_ajax_save_initial_user_medical_profile', 'save_initial_user_medical_profile');
add_action( 'wp_ajax_nopriv_save_initial_user_medical_profile', 'save_initial_user_medical_profile' ); // For anonymous users
function save_initial_user_medical_profile() {

    var_dump($_POST['data']);
    $user_id = get_current_user_id();
    $data = $_POST['data'];
    update_user_meta( $user_id, 'last_cigarette', $data['hvNck0WCKPsBb73XEzIF3'] );
    update_user_meta( $user_id, 'vaping_product', $data['Jobx7PHVwKL_yumEdi7Jl'] );
    update_user_meta( $user_id, 'heart_attack', $data['qceAKDJfEDuBQj7QD1gFF'] );
    update_user_meta( $user_id, 'are_you_pregnant', $data['3N7MEwRQQ8DyRyhUeWluZ'] );
    update_user_meta( $user_id, 'special_requirements', $data['vk1adCeUqE8VkWvf5Qqm6'] );
    update_user_meta( $user_id, 'emaile_documents', $data['B90LYTslk__msuLzLkQ31'] );
    update_user_meta( $user_id, 'confirm_safety_information', $data['gbHG9mDZV7bRmXggwJyYI'] );
}