<?php




// Add is_verified field
function is_verified_fields( $user ) {
    ?>
    <table class="form-table">
        <tr>
            <th>Is Verified:</th>
            <td>


                <p><label for="">
                        <input
                            id="is_verified"
                            name="is_verified"
                            type="checkbox"
                            value="verified"
                            <?php  echo (get_user_meta($user->ID, 'is_verified', true) == 'verified' ? 'checked' : ''); ?>/>

                    </label></p>

            </td>
        </tr>
    </table>
    <?php
}// Add is_verified field
add_action( 'show_user_profile', 'is_verified_fields' );
add_action( 'edit_user_profile', 'is_verified_fields' );





// store is_verified using cloudcheck form
function cloudcheck_global_verification() {
    
    if($_POST['user_id']) {
        $user = get_user_by('email', $_POST['user_id']);
        $user_id = $user->ID;
    } else {
        $user_id = get_current_user_id();
    }
    $value = 'verified';
//    $result = wp_update_user( [
//       'ID'       => $user_id,
//       'is_verified' => $value
//    ] );

    $result = update_user_meta( $user_id, 'is_verified', $value );

    if ( ! $result ) {
        echo  'An error has occurred, perhaps such a user does not exist.';
    }
    else {
        echo 'Verification completed successfully.';
    }
}// store is_verified using cloudcheck form
add_action('wp_ajax_cloudcheck_global_verification', 'cloudcheck_global_verification');
add_action( 'wp_ajax_nopriv_cloudcheck_global_verification', 'cloudcheck_global_verification' ); // For anonymous users



// store is_verified on user edit page
function is_verified_fields_save( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'is_verified', $_POST['is_verified'] );
}// store is_verified on user edit page
add_action( 'personal_options_update', 'is_verified_fields_save' );
add_action( 'edit_user_profile_update', 'is_verified_fields_save' );




// Add "I agree to the collection of my personal data" field
function is_agreed_fields( $user ) {
    ?>
    <table class="form-table">
        <tr>
            <th>I agree to the collection of my personal data:</th>
            <td>


                <p><label for="">
                        <input
                                id="is_agreed"
                                name="is_agreed"
                                type="checkbox"
                                value="agreed"
                            <?php  echo (get_user_meta($user->ID, 'is_agreed', true) == 'agreed' ? 'checked' : ''); ?>/>

                    </label></p>

            </td>
        </tr>
    </table>
    <?php
}// Add is_agreed field
add_action( 'show_user_profile', 'is_agreed_fields' );
add_action( 'edit_user_profile', 'is_agreed_fields' );

// store is_agreed on user edit page
function is_agreed_fields_save( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'is_agreed', $_POST['is_agreed'] );
}// store is_verified on user edit page
add_action( 'personal_options_update', 'is_agreed_fields_save' );
add_action( 'edit_user_profile_update', 'is_agreed_fields_save' );


// store is_agreed using form
function global_agreement() {

    $user_id = get_current_user_id();
    $value = 'agreed';
//    $result = wp_update_user( [
//       'ID'       => $user_id,
//       'is_verified' => $value
//    ] );

    $result = update_user_meta( $user_id, 'is_agreed', $value );


// Получим значение поля и проверим его с новым значением $new_value
    if ( get_user_meta($user_id, 'is_agreed', true ) != $value ) {
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

}// store is_agreed using form
add_action('wp_ajax_global_agreement', 'global_agreement');
add_action( 'wp_ajax_nopriv_global_agreement', 'global_agreement' ); // For anonymous users


