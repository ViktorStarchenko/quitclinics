<?php

/*
 * Redirect
 */
function advanced_form_integration_redirect( $url )
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo  $string ;
}

/*
 * Get form providers
 */
function adfoin_get_form_providers()
{
    $providers = array(
        'cf7' => __( 'Contact Form 7', 'advanced-form-integration' ),
    );
    $platform_settings = adfoin_get_action_platform_settings();
    $is_wc_active = ( isset( $platform_settings['woocommerce'] ) ? $platform_settings['woocommerce'] : '' );
    if ( true == $is_wc_active ) {
        $providers['woocommerce'] = __( 'WooCommerce', 'advanced-form-integration' );
    }
    $pro_items = array(
        'gravityforms'    => __( 'Gravity Forms', 'advanced-form-integration' ),
        'ninjaforms'      => __( 'Ninja Forms', 'advanced-form-integration' ),
        'calderaforms'    => __( 'Caldera Forms', 'advanced-form-integration' ),
        'elementorpro'    => __( 'Elementor Pro Form', 'advanced-form-integration' ),
        'everestforms'    => __( 'Everest Forms', 'advanced-form-integration' ),
        'fluentforms'     => __( 'WP Fluent Forms', 'advanced-form-integration' ),
        'formcraft'       => __( 'FormCraft 3', 'advanced-form-integration' ),
        'formcraftb'      => __( 'FormCraft Basic', 'advanced-form-integration' ),
        'formidable'      => __( 'Formidable Forms', 'advanced-form-integration' ),
        'forminator'      => __( 'Forminator Forms', 'advanced-form-integration' ),
        'happyforms'      => __( 'Happy Forms', 'advanced-form-integration' ),
        'plansoforms'     => __( 'PlanSo Forms', 'advanced-form-integration' ),
        'smartforms'      => __( 'Smart Forms', 'advanced-form-integration' ),
        'weforms'         => __( 'weForms', 'advanced-form-integration' ),
        'wpforms'         => __( 'WPForms', 'advanced-form-integration' ),
        'webhooksinbound' => __( 'Inbound Webhooks', 'advanced-form-integration' ),
    );
    $providers = $providers + $pro_items;
    return apply_filters( 'adfoin_form_providers', $providers );
}

/*
 * Get form providers HTML
 */
function adfoin_get_form_providers_html()
{
    $form_providers = adfoin_get_form_providers();
    $ex_list = array( 'cf7', 'woocommerce' );
    $providers_html = '';
    foreach ( $form_providers as $key => $provider ) {
        
        if ( adfoin_fs()->is_not_paying() ) {
            
            if ( in_array( $key, $ex_list ) ) {
                $providers_html .= '<option value="' . $key . '">' . $provider . '</option>';
                continue;
            }
            
            $providers_html .= '<option value="' . $key . '" disabled>' . $provider . ' (Pro Feature)</option>';
        }
    
    }
    return $providers_html;
}

/*
 * Get actions
 */
function adfoin_get_actions()
{
    $actions = array();
    return apply_filters( 'adfoin_action_providers', $actions );
}

/*
 * Get action providers
 */
function adfoin_get_action_porviders()
{
    $actions = adfoin_get_actions();
    $providers = array();
    foreach ( $actions as $key => $value ) {
        $providers[$key] = $value['title'];
    }
    return $providers;
}

/*
 * Get action tasks
 */
function adfoin_get_action_tasks( $provider = "" )
{
    $actions = adfoin_get_actions();
    $tasks = array();
    if ( $provider ) {
        foreach ( $actions as $key => $value ) {
            if ( $provider == $key ) {
                $tasks = $value['tasks'];
            }
        }
    }
    return $tasks;
}

/*
 * Settings Tabs List
 */
function adfoin_get_settings_tabs()
{
    $tabs = array(
        'general' => __( 'General', 'advanced-form-integration' ),
    );
    return apply_filters( 'adfoin_settings_tabs', $tabs );
}

function adfoin_get_action_platform_list()
{
    return array(
        'activecampaign'  => array(
        'title' => __( 'ActiveCampaign', 'advanced-form-integration' ),
        'basic' => 'activecampaign',
    ),
        'agilecrm'        => array(
        'title' => __( 'Agile CRM', 'advanced-form-integration' ),
        'basic' => 'agilecrm',
    ),
        'asana'           => array(
        'key'   => 'asana',
        'title' => __( 'Asana', 'advanced-form-integration' ),
        'basic' => 'asana',
    ),
        'autopilotnew'    => array(
        'title' => __( 'Autopilot', 'advanced-form-integration' ),
        'basic' => 'autopilotnew',
    ),
        'autopilot'       => array(
        'title' => __( 'Autopilot Journeys', 'advanced-form-integration' ),
        'basic' => 'autopilot',
    ),
        'aweber'          => array(
        'title' => __( 'Aweber', 'advanced-form-integration' ),
        'basic' => 'aweber',
    ),
        'benchmark'       => array(
        'title' => __( 'Benchmark', 'advanced-form-integration' ),
        'basic' => 'benchmark',
    ),
        'campaignmonitor' => array(
        'title' => __( 'Campaign Monitor', 'advanced-form-integration' ),
        'basic' => 'campaignmonitor',
    ),
        'clinchpad'       => array(
        'title' => __( 'ClinchPad', 'advanced-form-integration' ),
        'basic' => 'clinchpad',
    ),
        'close'           => array(
        'title' => __( 'Close', 'advanced-form-integration' ),
        'basic' => 'close',
    ),
        'constantcontact' => array(
        'title' => __( 'Constant Contact', 'advanced-form-integration' ),
        'basic' => 'constantcontact',
    ),
        'convertkit'      => array(
        'title' => __( 'ConvertKit', 'advanced-form-integration' ),
        'basic' => 'convertkit',
    ),
        'copper'          => array(
        'title' => __( 'Copper', 'advanced-form-integration' ),
        'basic' => 'copper',
    ),
        'curated'         => array(
        'title' => __( 'Curated', 'advanced-form-integration' ),
        'basic' => 'curated',
    ),
        'directiq'        => array(
        'title' => __( 'DirectIQ', 'advanced-form-integration' ),
        'basic' => 'directiq',
    ),
        'drip'            => array(
        'title' => __( 'Drip', 'advanced-form-integration' ),
        'basic' => 'drip',
    ),
        'elasticemail'    => array(
        'title' => __( 'Elastic Email', 'advanced-form-integration' ),
        'basic' => 'elasticemail',
    ),
        'emailoctopus'    => array(
        'title' => __( 'EmailOctopus', 'advanced-form-integration' ),
        'basic' => 'emailoctopus',
    ),
        'everwebinar'     => array(
        'title' => __( 'EverWebinar', 'advanced-form-integration' ),
        'basic' => 'everwebinar',
    ),
        'freshsales'      => array(
        'title' => __( 'Freshsales', 'advanced-form-integration' ),
        'basic' => 'freshsales',
    ),
        'getresponse'     => array(
        'title' => __( 'GetResponse', 'advanced-form-integration' ),
        'basic' => 'getresponse',
    ),
        'googlecalendar'  => array(
        'title' => __( 'Google Calendar', 'advanced-form-integration' ),
        'basic' => 'googlecalendar',
    ),
        'googlesheets'    => array(
        'title' => __( 'Google Sheets', 'advanced-form-integration' ),
        'basic' => 'googlesheets',
    ),
        'hubspot'         => array(
        'title' => __( 'Hubspot', 'advanced-form-integration' ),
        'basic' => 'hubspot',
    ),
        'insightly'       => array(
        'title' => __( 'Insightly CRM', 'advanced-form-integration' ),
        'basic' => 'insightly',
    ),
        'jumplead'        => array(
        'title' => __( 'Jumplead', 'advanced-form-integration' ),
        'basic' => 'jumplead',
    ),
        'keap'            => array(
        'title' => __( 'Keap', 'advanced-form-integration' ),
        'basic' => 'keap',
    ),
        'klaviyo'         => array(
        'title' => __( 'Klaviyo', 'advanced-form-integration' ),
        'basic' => 'klaviyo',
    ),
        'lemlist'         => array(
        'title' => __( 'lemlist', 'advanced-form-integration' ),
        'basic' => 'lemlist',
    ),
        'liondesk'        => array(
        'title' => __( 'LionDesk', 'advanced-form-integration' ),
        'basic' => 'liondesk',
    ),
        'mailchimp'       => array(
        'title' => __( 'Mailchimp', 'advanced-form-integration' ),
        'basic' => 'mailchimp',
    ),
        'mailerlite'      => array(
        'title' => __( 'MailerLite', 'advanced-form-integration' ),
        'basic' => 'mailerlite',
    ),
        'mailify'         => array(
        'title' => __( 'Mailify', 'advanced-form-integration' ),
        'basic' => 'mailify',
    ),
        'mailjet'         => array(
        'title' => __( 'Mailjet', 'advanced-form-integration' ),
        'basic' => 'mailjet',
    ),
        'moosend'         => array(
        'title' => __( 'Moosend', 'advanced-form-integration' ),
        'basic' => 'moosend',
    ),
        'omnisend'        => array(
        'title' => __( 'Omnisend', 'advanced-form-integration' ),
        'basic' => 'omnisend',
    ),
        'pabbly'          => array(
        'title' => __( 'Pabbly', 'advanced-form-integration' ),
        'basic' => 'pabbly',
    ),
        'pipedrive'       => array(
        'title' => __( 'Pipedrive', 'advanced-form-integration' ),
        'basic' => 'pipedrive',
    ),
        'pushover'        => array(
        'title' => __( 'Pushover', 'advanced-form-integration' ),
        'basic' => 'pushover',
    ),
        'revue'           => array(
        'title' => __( 'Revue', 'advanced-form-integration' ),
        'basic' => 'revue',
    ),
        'sendfox'         => array(
        'title' => __( 'Sendfox', 'advanced-form-integration' ),
        'basic' => 'sendfox',
    ),
        'sendinblue'      => array(
        'title' => __( 'Sendinblue', 'advanced-form-integration' ),
        'basic' => 'sendinblue',
    ),
        'sendpulse'       => array(
        'title' => __( 'Sendpulse', 'advanced-form-integration' ),
        'basic' => 'sendpulse',
    ),
        'sendy'           => array(
        'title' => __( 'Sendy', 'advanced-form-integration' ),
        'basic' => 'sendy',
    ),
        'slack'           => array(
        'title' => __( 'Slack', 'advanced-form-integration' ),
        'basic' => 'slack',
    ),
        'smartsheet'      => array(
        'title' => __( 'Smartsheet', 'advanced-form-integration' ),
        'basic' => 'smartsheet',
    ),
        'trello'          => array(
        'title' => __( 'Trello', 'advanced-form-integration' ),
        'basic' => 'trello',
    ),
        'twilio'          => array(
        'title' => __( 'Twilio', 'advanced-form-integration' ),
        'basic' => 'twilio',
    ),
        'webhook'         => array(
        'title' => __( 'Webhook', 'advanced-form-integration' ),
        'basic' => 'webhook',
    ),
        'webinarjam'      => array(
        'title' => __( 'WebinarJam', 'advanced-form-integration' ),
        'basic' => 'webinarjam',
    ),
        'woocommerce'     => array(
        'title' => __( 'WooCommerce', 'advanced-form-integration' ),
        'basic' => 'woocommerce',
    ),
        'woodpecker'      => array(
        'title' => __( 'Woodpecker.io', 'advanced-form-integration' ),
        'basic' => 'woodpecker',
    ),
        'wordpress'       => array(
        'title' => __( 'WordPress', 'advanced-form-integration' ),
        'basic' => 'wordpress',
    ),
        'zapier'          => array(
        'title' => __( 'Zapier', 'advanced-form-integration' ),
        'basic' => 'zapier',
    ),
        'zohocampaigns'   => array(
        'title' => __( 'ZOHO Campaigns', 'advanced-form-integration' ),
        'basic' => 'zohocampaigns',
    ),
    );
}

function adfoin_get_action_platform_settings()
{
    global  $wpdb ;
    $settings = ( get_option( 'adfoin_general_settings_platforms' ) ? get_option( 'adfoin_general_settings_platforms' ) : array() );
    $saved_records = $wpdb->get_results( "SELECT form_provider, action_provider FROM {$wpdb->prefix}adfoin_integration WHERE status = 1", ARRAY_A );
    if ( !is_wp_error( $saved_records ) ) {
        
        if ( $saved_records && is_array( $saved_records ) ) {
            $form_providers = wp_list_pluck( $saved_records, 'form_provider' );
            if ( $form_providers ) {
                if ( in_array( 'woocommerce', array_unique( $form_providers ) ) ) {
                    $settings['woocommerce'] = true;
                }
            }
            $action_providers = wp_list_pluck( $saved_records, 'action_provider' );
            
            if ( $action_providers ) {
                $action_providers = array_unique( $action_providers );
                foreach ( $action_providers as $single ) {
                    $settings[$single] = true;
                }
            }
        
        }
    
    }
    return $settings;
}

add_action(
    'adfoin_settings_view',
    'adfoin_general_settings_view',
    10,
    1
);
function adfoin_general_settings_view( $current_tab )
{
    if ( $current_tab != 'general' ) {
        return;
    }
    $nonce = wp_create_nonce( "adfoin_general_settings" );
    $log_settings = ( get_option( 'adfoin_general_settings_log' ) ? get_option( 'adfoin_general_settings_log' ) : '' );
    $st_settings = ( get_option( 'adfoin_general_settings_st' ) ? get_option( 'adfoin_general_settings_st' ) : '' );
    $platform_settings = adfoin_get_action_platform_settings();
    $platforms = adfoin_get_action_platform_list();
    ?>

    <form name="general_save_form" action="<?php 
    echo  esc_url( admin_url( 'admin-post.php' ) ) ;
    ?>"
          method="post" class="container">

        <input type="hidden" name="action" value="adfoin_save_general_settings">
        <input type="hidden" name="_nonce" value="<?php 
    echo  $nonce ;
    ?>"/>

        <div class="afi-row">
        <div class="col-full">
            <h3><?php 
    _e( 'Activate Platforms', 'advacned-form-integration' );
    ?></h3>
            <div class="afi-checkbox-container">
                <?php 
    foreach ( $platforms as $key => $platform ) {
        $status = ( isset( $platform_settings[$key] ) ? $platform_settings[$key] : '' );
        ?>
                    <div class="afi-checkbox">
                    <div class="afi-elements-info">
                        <p class="afi-el-title">
                            <label for="<?php 
        echo  esc_attr( $key ) ;
        ?>"><?php 
        echo  esc_html( $platform['title'] ) ;
        ?></label>
                        </p>
                    </div>
                    <input type="checkbox" value="1" id="<?php 
        echo  esc_attr( $key ) ;
        ?>" name="platforms[<?php 
        echo  esc_attr( $key ) ;
        ?>]" <?php 
        checked( $status, 1 );
        ?>>
                </div>
                <?php 
    }
    ?>
                
            </div>

            <h3><?php 
    _e( 'General Settings', 'advacned-form-integration' );
    ?></h3>
            <div class="afi-checkbox-container">
                <div class="afi-checkbox">
                    <div class="afi-elements-info">
                        <p class="afi-el-title">
                        <?php 
    _e( 'Disable Log', 'advanced-form-integration' );
    ?>
                        </p>
                    </div>
                    <input type="checkbox" value="1" name="adfoin_disable_log" <?php 
    checked( $log_settings, 1 );
    ?>>
                </div>
                <div class="afi-checkbox">
                    <div class="afi-elements-info">
                        <p class="afi-el-title">
                        <?php 
    _e( 'Disable Special Tags', 'advanced-form-integration' );
    ?>
                        </p>
                    </div>
                    <input type="checkbox" value="1" name="adfoin_disable_st" <?php 
    checked( $st_settings, 1 );
    ?>>
                </div>
            </div>
        </div>
    </div>
        
    <?php 
    submit_button();
    ?>
    </form>

    <?php 
}

add_action(
    'admin_post_adfoin_save_general_settings',
    'adfoin_save_general_settings',
    10,
    0
);
function adfoin_save_general_settings()
{
    // Security Check
    if ( !wp_verify_nonce( $_POST['_nonce'], 'adfoin_general_settings' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }
    $log_settings = ( isset( $_POST["adfoin_disable_log"] ) ? sanitize_text_field( $_POST["adfoin_disable_log"] ) : '' );
    $st_settings = ( isset( $_POST["adfoin_disable_st"] ) ? sanitize_text_field( $_POST["adfoin_disable_st"] ) : '' );
    $default_platforms = array_fill_keys( array_keys( adfoin_get_action_platform_list() ), false );
    $activated_platforms = ( isset( $_POST["platforms"] ) ? adfoin_sanitize_text_or_array_field( $_POST["platforms"] ) : array() );
    $all_platforms = array_merge( $default_platforms, array_fill_keys( array_keys( array_intersect_key( $activated_platforms, $default_platforms ) ), true ) );
    // Save
    update_option( "adfoin_general_settings_platforms", $all_platforms );
    update_option( "adfoin_general_settings_log", $log_settings );
    update_option( "adfoin_general_settings_st", $st_settings );
    advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings" );
}

/*
 * Sanitize text or array field
 */
function adfoin_sanitize_text_or_array_field( $array_or_string )
{
    
    if ( is_string( $array_or_string ) ) {
        $array_or_string = stripslashes( $array_or_string );
    } elseif ( is_array( $array_or_string ) ) {
        foreach ( $array_or_string as $key => &$value ) {
            
            if ( is_array( $value ) ) {
                $value = adfoin_sanitize_text_or_array_field( $value );
            } else {
                $value = stripslashes( $value );
            }
        
        }
    }
    
    return $array_or_string;
}

/*
 * Get parsed value
 */
function adfoin_get_parsed_values( $field, $posted_data )
{
    foreach ( $posted_data as $key => $value ) {
        
        if ( is_array( $value ) ) {
            $multi = 0;
            foreach ( $value as $single ) {
                
                if ( is_array( $single ) ) {
                    $multi = 1;
                    break;
                }
            
            }
            
            if ( $multi ) {
                $value = json_encode( $value );
            } else {
                $value = @implode( ",", $value );
            }
        
        }
        
        $field = str_replace( "{{" . $key . "}}", $value, $field );
    }
    $field = preg_replace( "/{{.+?}}/", "", $field );
    return $field;
}

/*
 * Insert data to log
 */
function adfoin_add_to_log(
    $return,
    $url,
    $args,
    $record
)
{
    global  $wpdb ;
    $log_settings = ( get_option( 'adfoin_general_settings_log' ) ? get_option( 'adfoin_general_settings_log' ) : "" );
    if ( "1" == $log_settings ) {
        return;
    }
    $log_table = $wpdb->prefix . 'adfoin_log';
    if ( isset( $args['body'] ) ) {
        if ( !is_array( $args['body'] ) ) {
            if ( null != json_decode( $args['body'] ) ) {
                $args['body'] = json_decode( $args['body'] );
            }
        }
    }
    $request_data = json_encode( array(
        'url'  => $url,
        'args' => $args,
    ) );
    $result = $wpdb->insert( $log_table, array(
        'response_code'    => $return["response"]["code"],
        'response_message' => $return["response"]["message"],
        'integration_id'   => $record["id"],
        'request_data'     => $request_data,
        'response_data'    => $return["body"],
    ) );
    return;
}

/*
 * Get User IP
 */
function adfoin_get_user_ip()
{
    // Get real visitor IP behind CloudFlare network
    
    if ( isset( $_SERVER["HTTP_CF_CONNECTING_IP"] ) ) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = ( $_SERVER["HTTP_CF_CONNECTING_IP"] ? $_SERVER["HTTP_CF_CONNECTING_IP"] : '' );
    }
    
    $client = ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ? $_SERVER['HTTP_CLIENT_IP'] : '' );
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];
    
    if ( filter_var( $client, FILTER_VALIDATE_IP ) ) {
        $ip = $client;
    } elseif ( filter_var( $forward, FILTER_VALIDATE_IP ) ) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }
    
    return $ip;
}

function adfoin_get_cl_conditions()
{
    return array(
        "equal_to"         => __( 'Equal to', 'advanced-form-integration' ),
        "not_equal_to"     => __( 'Not equal to', 'advanced-form-integration' ),
        "contains"         => __( 'Contains', 'advanced-form-integration' ),
        "does_not_contain" => __( 'Does not Contain', 'advanced-form-integration' ),
        "starts_with"      => __( 'Starts with', 'advanced-form-integration' ),
        "ends_with"        => __( 'Ends with', 'advanced-form-integration' ),
        "greater_than"     => __( 'Greater Than (number)', 'advanced-form-integration' ),
        "less_than"        => __( 'Less Than (number)', 'advanced-form-integration' ),
    );
}

function adfoin_match_conditional_logic( $cl, $posted_data )
{
    if ( $cl["active"] != "yes" ) {
        return true;
    }
    $match = 0;
    $length = count( $cl["conditions"] );
    foreach ( $cl["conditions"] as $condition ) {
        if ( !$condition["field"] && $condition["field"] != 0 ) {
            continue;
        }
        $field = ( strpos( $condition["field"], '{{' ) !== false && strpos( $condition["field"], '}}' ) !== false ? $condition["field"] : '{{' . trim( $condition["field"] ) . '}}' );
        $field_value = adfoin_get_parsed_values( $field, $posted_data );
        if ( adfoin_match_single_logic( $field_value, $condition["operator"], $condition["value"] ) ) {
            $match++;
        }
    }
    if ( $cl["match"] == "any" && $match > 0 ) {
        return true;
    }
    if ( $cl["match"] == "all" && $match == $length ) {
        return true;
    }
    return false;
}

function adfoin_match_single_logic( $data, $operator, $value )
{
    $result = false;
    switch ( $operator ) {
        case 'equal_to':
            if ( $data == $value ) {
                $result = true;
            }
            break;
        case 'not_equal_to':
            if ( $data != $value ) {
                return true;
            }
            break;
        case 'greater_than':
            if ( (double) $data > (double) $value ) {
                return true;
            }
            break;
        case 'less_than':
            if ( (double) $data < (double) $value ) {
                return true;
            }
            break;
        case 'contains':
            if ( strpos( $data, $value ) !== false ) {
                return true;
            }
            break;
        case 'does_not_contains':
            if ( strpos( $data, $value ) === false ) {
                return true;
            }
            break;
        case 'starts_with':
            $length = strlen( $value );
            return substr( $data, 0, $length ) === $value;
            break;
        case 'ends_with':
            $length = strlen( $value );
            if ( $length == 0 ) {
                return true;
            }
            if ( substr( $data, -$length ) === $value ) {
                return true;
            }
        default:
            return false;
    }
    return $result;
}

function adfoin_get_special_tags()
{
    $st_settings = ( get_option( 'adfoin_general_settings_st' ) ? get_option( 'adfoin_general_settings_st' ) : "" );
    if ( "1" == $st_settings ) {
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
        '_user_email'        => __( '_User_Email', 'advanced-form-integration' ),
    );
    return $special_tags;
}

function adfoin_get_special_tags_values( $post )
{
    $st_settings = ( get_option( 'adfoin_general_settings_st' ) ? get_option( 'adfoin_general_settings_st' ) : "" );
    if ( "1" == $st_settings ) {
        return array();
    }
    if ( !function_exists( 'wp_get_current_user' ) ) {
        include ABSPATH . "wp-includes/pluggable.php";
    }
    global  $current_user ;
    wp_get_current_user();
    $special_tags = adfoin_get_special_tags();
    $values = array();
    if ( !empty($special_tags) ) {
        foreach ( $special_tags as $key => $value ) {
            $values[$key] = adfoin_get_single_special_tag_value( $key, $current_user, $post );
        }
    }
    return $values;
}

function adfoin_get_single_special_tag_value( $tag, $current_user, $post )
{
    switch ( $tag ) {
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
            return ( isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( $_SERVER['HTTP_USER_AGENT'], 0, 254 ) : '' );
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
            return ( is_object( $post ) ? $post->ID : "" );
            break;
        case "_post_name":
            return ( is_object( $post ) ? $post->post_name : "" );
            break;
        case "_post_title":
            return ( is_object( $post ) ? $post->post_title : "" );
            break;
        case "_post_url":
            return ( is_object( $post ) ? get_permalink( $post->ID ) : "" );
            break;
        case "_user_id":
            return ( isset( $current_user->ID ) ? $current_user->ID : "" );
            break;
        case "_user_first_name":
            return ( isset( $current_user->ID ) ? $current_user->user_firstname : "" );
            break;
        case "_user_last_name":
            return ( isset( $current_user->ID ) ? $current_user->user_lastname : "" );
            break;
        case "_user_display_name":
            return ( isset( $current_user->ID ) ? $current_user->display_name : "" );
            break;
        case "_user_email":
            return ( isset( $current_user->ID ) ? $current_user->user_email : "" );
            break;
    }
    return true;
}

function adfoin_is_valid_md5( $md5 = '' )
{
    return preg_match( '/^[a-f0-9]{32}$/', $md5 );
}
