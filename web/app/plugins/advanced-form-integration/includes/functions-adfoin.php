<?php

/*
 * Redirect
 */
function advanced_form_integration_redirect( $url ) {
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo  $string ;
}

/*
 * Get form providers
 */
function adfoin_get_form_providers() {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';

    $providers = array();

    if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
        $providers['cf7'] = __( 'Contact Form 7', 'advanced-form-integration' );
    }

    return apply_filters( 'adfoin_form_providers', $providers );
}

/*
 * Get actions
 */
function adfoin_get_actions() {
    $actions = array();

    return apply_filters( 'adfoin_action_providers', $actions );
}

/*
 * Get action providers
 */
function adfoin_get_action_porviders() {
    $actions   = adfoin_get_actions();
    $providers = array();

    foreach( $actions as $key => $value ) {
        $providers[$key] = $value['title'];
    }

    return $providers;
}

/*
 * Get action tasks
 */
function adfoin_get_action_tasks( $provider = "" ) {
    $actions = adfoin_get_actions();
    $tasks   = array();

    if( $provider ) {
        foreach( $actions as $key => $value ) {
            if( $provider == $key ) {
                $tasks = $value['tasks'];
            }
        }
    }

    return $tasks;
}

/*
 * Settings Tabs List
 */
function adfoin_get_settings_tabs() {
    $tabs = array(
        'general' => __( 'General', 'advanced-form-integration' )
    );

    return apply_filters( 'adfoin_settings_tabs', $tabs );
}

add_action( 'adfoin_settings_view', 'adfoin_general_settings_view', 10, 1 );

function adfoin_general_settings_view( $current_tab ) {
    if( $current_tab != 'general' ) {
        return;
    }

    $nonce        = wp_create_nonce( "adfoin_general_settings" );
    $log_settings = get_option( 'adfoin_general_settings_log' ) ? get_option( 'adfoin_general_settings_log' ) : "";
    $st_settings  = get_option( 'adfoin_general_settings_st' ) ? get_option( 'adfoin_general_settings_st' ) : "";
    ?>

    <form name="general_save_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
          method="post" class="container">

        <input type="hidden" name="action" value="adfoin_save_general_settings">
        <input type="hidden" name="_nonce" value="<?php echo $nonce ?>"/>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <?php _e( 'Disable Log', 'advanced-form-integration' ); ?></th>
                <td>
                <input type="checkbox" value="1" name="adfoin_disable_log" <?php checked( $log_settings, 1 ); ?>>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"> <?php _e( 'Disable Special Tags', 'advanced-form-integration' ); ?></th>
                <td>
                <input type="checkbox" value="1" name="adfoin_disable_st" <?php checked( $st_settings, 1 ); ?>>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>

    <?php
}

add_action( 'admin_post_adfoin_save_general_settings', 'adfoin_save_general_settings', 10, 0 );

function adfoin_save_general_settings() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'adfoin_general_settings' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $log_settings = sanitize_text_field( $_POST["adfoin_disable_log"] );
    $st_settings  = sanitize_text_field( $_POST["adfoin_disable_st"] );

    // Save
    update_option( "adfoin_general_settings_log", $log_settings );
    update_option( "adfoin_general_settings_st", $st_settings );

    advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings" );
}

/*
 * Sanitize text or array field
 */
function adfoin_sanitize_text_or_array_field($array_or_string) {
    if( is_string($array_or_string) ){
        $array_or_string = sanitize_text_field($array_or_string);
    }elseif( is_array($array_or_string) ){
        foreach ( $array_or_string as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = adfoin_sanitize_text_or_array_field($value);
            }
            else {
                $value = sanitize_text_field( $value );
            }
        }
    }

    return $array_or_string;
}

/*
 * Get parsed value
 */
function adfoin_get_parsed_values($field, $posted_data) {
    foreach( $posted_data as $key => $value ) {
        if( is_array( $value ) ) {
            $multi = 0;

            foreach( $value as $single ) {
                if( is_array( $single ) ) {
                    $multi = 1;
                    break;
                }
            }

            if( $multi ) {
                $value = json_encode( $value );
            }else {
                $value = @implode( ",", $value );
            }
        }

        $field = str_replace( "{{" . $key . "}}", $value, $field );
    }

    $field = preg_replace("/{{.+}}/", "", $field );

    return $field;
}

/*
 * Insert data to log
 */
function adfoin_add_to_log( $return, $url, $args, $record ) {
    global $wpdb;
    $log_settings = get_option( 'adfoin_general_settings_log' ) ? get_option( 'adfoin_general_settings_log' ) : "";

    if( "1" == $log_settings ) {
        return;
    }

    $log_table = $wpdb->prefix . 'adfoin_log';

    $request_data = json_encode(
        array(
            'url'  => $url,
            'args' => $args
        )
    );

    $result = $wpdb->insert(
        $log_table,
        array(
            'response_code'    => $return["response"]["code"],
            'response_message' => $return["response"]["message"],
            'integration_id'   => $record["id"],
            'request_data'     => $request_data,
            'response_data'    => $return["body"],
        )
    );

    return;
}

/*
 * Get User IP
 */
function adfoin_get_user_ip() {
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"] ? $_SERVER["HTTP_CF_CONNECTING_IP"] : '';
    }
    $client  = isset( $_SERVER['HTTP_CLIENT_IP'] ) ? $_SERVER['HTTP_CLIENT_IP'] : '';
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    }
    else {
        $ip = $remote;
    }

    return $ip;
}

function adfoin_get_cl_conditions() {
    return array(
        "equal_to"         => __( 'Equal to', 'advanced-form-integration' ),
        "not_equal_to"     => __( 'Not equal to', 'advanced-form-integration' ),
        "contains"         => __( 'Contains', 'advanced-form-integration' ),
        "does_not_contain" => __( 'Does not Contain', 'advanced-form-integration' ),
        "starts_with"      => __( 'Starts with', 'advanced-form-integration' ),
        "ends_with"        => __( 'Ends with', 'advanced-form-integration' )
    );
}

function adfoin_match_conditional_logic( $cl, $posted_data ) {
    if( $cl["active"] != "yes" ) {
        return true;
    }

    $match  = 0;
    $length = count( $cl["conditions"] );

    foreach( $cl["conditions"] as $condition ) {
        if( !$condition["field"] ) {
            continue;
        }
        foreach( $posted_data as $key => $data ) {
            if( is_array( $data ) ) {
                $data = implode( ",", $data );
            }

            if( $condition["field"] == $key ) {
                if( adfoin_match_single_logic( $data, $condition["operator"], $condition["value"] ) ) {
                    $match++;
                }
            }
        }
    }

    if( $cl["match"] == "any" && $match > 0 ) {
        return true;
    }

    if( $cl["match"] == "all" && $match == $length ) {
        return true;
    }

    return false;
}


function adfoin_match_single_logic($data, $operator, $value ) {
    $result = false;

    switch( $operator ) {
        case 'equal_to':
            if( $data == $value ) {
                $result = true;
            }
            break;
        case 'not_equal_to':
            if( $data != $value ) {
                return true;
            }
            break;
        case 'contains':
            if ( strpos($data, $value ) !== false ) {
                return true;
            }
            break;
        case 'does_not_contains':
            if ( strpos($data, $value ) === false ) {
                return true;
            }
            break;
        case 'starts_with':
            $length = strlen( $value );
            return ( substr( $data, 0, $length ) === $value );
            break;
        case 'ends_with':
            $length = strlen( $value );
            if( $length == 0 ) {
                return true;
            }
            if( substr( $data, -$length ) === $value ) {
                return true;
            }
        default: return false;
    }

    return $result;
}

function adfoin_get_special_tags() {

    $st_settings = get_option( 'adfoin_general_settings_st' ) ? get_option( 'adfoin_general_settings_st' ) : "";

    if( "1" == $st_settings ) {
        return array();
    }

    $special_tags = array(
        '_submission_date'   => __( '_Submission_Date', 'advanced-form-integration' ),
        '_date'              => __( '_Date', 'advanced-form-integration' ),
        '_time'              => __( '_Time', 'advanced-form-integration' ),
        '_weekday'           => __( '_Weekday', 'advanced-form-integration' ),
        '_user_ip'           => __( '_User_IP', 'advanced-form-integration' ),
        '_user_agent'        => __( '_User_Agent', 'advanced-form-integration' ),
        '_site_title'        => __( '_Site_Title', 'advanced-form-integration' ),
        '_site_description'  => __( '_Site_Description', 'advanced-form-integration' ),
        '_site_url'          => __( '_Site_URL', 'advanced-form-integration' ),
        '_site_admin_email'  => __( '_Site_Admin_Email', 'advanced-form-integration' ),
        '_post_id'           => __( '_Post_ID', 'advanced-form-integration' ),
        '_post_name'         => __( '_Post_Name', 'advanced-form-integration' ),
        '_post_title'        => __( '_Post_Title', 'advanced-form-integration' ),
        '_post_url'          => __( '_Post_URL', 'advanced-form-integration' ),
        '_user_id'           => __( '_User_ID', 'advanced-form-integration' ),
        '_user_first_name'   => __( '_User_First_Name', 'advanced-form-integration' ),
        '_user_last_name'    => __( '_User_Last_Name', 'advanced-form-integration' ),
        '_user_display_name' => __( '_User_Display_Name', 'advanced-form-integration' ),
        '_user_email'        => __( '_User_Email', 'advanced-form-integration' )
    );

    return $special_tags;
}

function adfoin_get_special_tags_values( $post ) {

    $st_settings = get_option( 'adfoin_general_settings_st' ) ? get_option( 'adfoin_general_settings_st' ) : "";

    if( "1" == $st_settings ) {
        return array();
    }

    if(!function_exists('wp_get_current_user')) {
        include(ABSPATH . "wp-includes/pluggable.php");
    }

    global $current_user;
    wp_get_current_user();
    $special_tags = adfoin_get_special_tags();
    $values       = array();

    if( !empty( $special_tags ) ) {
        foreach( $special_tags as $key => $value ) {
            $values[$key] = adfoin_get_single_special_tag_value( $key, $current_user, $post );
        }
    }

    return $values;
}

function adfoin_get_single_special_tag_value( $tag, $current_user, $post ) {
    switch( $tag ) {
        case "submission_date":
            return date( "Y-m-d H:i:s" );
            break;
        case "_submission_date":
            return wp_date( 'Y-m-d H:i:s' );
            break;
        case "_date":
            return wp_date( get_option( 'date_format' ) );
            break;
        case "_time":
            return wp_date( get_option( 'time_format' ) );
            break;
        case "_weekday":
            return wp_date( 'l' );
            break;
        case "user_ip":
            return adfoin_get_user_ip();
            break;
        case "_user_ip":
            return adfoin_get_user_ip();
            break;
        case "_user_agent":
            return isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( $_SERVER['HTTP_USER_AGENT'], 0, 254 ) : '';
            break;
        case "_site_title":
            return get_bloginfo( 'name' );
            break;
        case "_site_description":
            return get_bloginfo( 'description' );
            break;
        case "_site_url":
            return get_bloginfo( 'url' );
            break;
        case "_site_admin_email":
            return get_bloginfo( 'admin_email' );
            break;
        case "_post_id":
            return is_object ( $post ) ? $post->ID : "";
            break;
        case "_post_name":
            return is_object ( $post ) ? $post->post_name : "";
            break;
        case "_post_title":
            return is_object ( $post ) ? $post->post_title : "";
            break;
        case "_post_url":
            return is_object ( $post ) ? get_permalink( $post->ID ) : "";
            break;
        case "_user_id":
            return isset( $current_user->ID ) ? $current_user->ID : "";
            break;
        case "_user_first_name":
            return isset( $current_user->ID ) ? $current_user->user_firstname : "";
            break;
        case "_user_last_name":
            return isset( $current_user->ID ) ? $current_user->user_lastname : "";
            break;
        case "_user_display_name":
            return isset( $current_user->ID ) ? $current_user->display_name : "";
            break;
        case "_user_email":
            return isset( $current_user->ID ) ? $current_user->user_email : "";
            break;
    }
    return true;
}

function adfoin_is_valid_md5( $md5 ='' ) {
    return preg_match( '/^[a-f0-9]{32}$/', $md5 );
}