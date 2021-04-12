<?php

add_filter( 'adfoin_action_providers', 'adfoin_close_actions', 10, 1 );

function adfoin_close_actions( $actions ) {

    $actions['close'] = array(
        'title' => __( 'Close', 'advanced-form-integration' ),
        'tasks' => array(
            'add_lead'   => __( 'Create New Lead', 'advanced-form-integration' )
        )
    );

    return $actions;
}

add_filter( 'adfoin_settings_tabs', 'adfoin_close_settings_tab', 10, 1 );

function adfoin_close_settings_tab( $providers ) {
    $providers['close'] = __( 'close', 'advanced-form-integration' );

    return $providers;
}

add_action( 'adfoin_settings_view', 'adfoin_close_settings_view', 10, 1 );

function adfoin_close_settings_view( $current_tab ) {
    if( $current_tab != 'close' ) {
        return;
    }

    $nonce     = wp_create_nonce( "adfoin_close_settings" );
    $api_token = get_option( 'adfoin_close_api_token' ) ? get_option( 'adfoin_close_api_token' ) : "";
    ?>

    <form name="close_save_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
          method="post" class="container">

        <input type="hidden" name="action" value="adfoin_save_close_api_token">
        <input type="hidden" name="_nonce" value="<?php echo $nonce ?>"/>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <?php _e( 'API Key', 'advanced-form-integration' ); ?></th>
                <td>
                    <input type="text" name="adfoin_close_api_token"
                           value="<?php echo $api_token; ?>" placeholder="<?php _e( 'Please enter API Token', 'advanced-form-integration' ); ?>"
                           class="regular-text"/>
                    <p class="description" id="code-description"><?php _e( 'Please go to Settings > API keys', 'advanced-form-integration' ); ?></a></p>
                </td>

            </tr>
        </table>
        <?php submit_button(); ?>
    </form>

    <?php
}

add_action( 'admin_post_adfoin_save_close_api_token', 'adfoin_save_close_api_token', 10, 0 );

function adfoin_save_close_api_token() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'adfoin_close_settings' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $api_token = sanitize_text_field( $_POST["adfoin_close_api_token"] );

    // Save tokens
    update_option( "adfoin_close_api_token", $api_token );

    advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings&tab=close" );
}

add_action( 'adfoin_add_js_fields', 'adfoin_close_js_fields', 10, 1 );

function adfoin_close_js_fields( $field_data ) {}

add_action( 'adfoin_action_fields', 'adfoin_close_action_fields' );

function adfoin_close_action_fields() {
    ?>
    <script type="text/template" id="close-action-template">
        <table class="form-table">
            <tr valign="top" v-if="action.task == 'add_contact'">
                <th scope="row">
                    <?php esc_attr_e( 'Lead Fields', 'advanced-form-integration' ); ?>
                </th>
                <td scope="row">

                </td>
            </tr>

            <editable-field v-for="field in fields" v-bind:key="field.value" v-bind:field="field" v-bind:trigger="trigger" v-bind:action="action" v-bind:fielddata="fielddata"></editable-field>
        </table>
    </script>
    <?php
}

/*
 * Saves connection mapping
 */
function adfoin_close_save_integration() {
    $params = array();
    parse_str( adfoin_sanitize_text_or_array_field( $_POST['formData'] ), $params );

    $trigger_data = isset( $_POST["triggerData"] ) ? adfoin_sanitize_text_or_array_field( $_POST["triggerData"] ) : array();
    $action_data  = isset( $_POST["actionData"] ) ? adfoin_sanitize_text_or_array_field( $_POST["actionData"] ) : array();
    $field_data   = isset( $_POST["fieldData"] ) ? adfoin_sanitize_text_or_array_field( $_POST["fieldData"] ) : array();

    $integration_title = isset( $trigger_data["integrationTitle"] ) ? $trigger_data["integrationTitle"] : "";
    $form_provider_id  = isset( $trigger_data["formProviderId"] ) ? $trigger_data["formProviderId"] : "";
    $form_id           = isset( $trigger_data["formId"] ) ? $trigger_data["formId"] : "";
    $form_name         = isset( $trigger_data["formName"] ) ? $trigger_data["formName"] : "";
    $action_provider   = isset( $action_data["actionProviderId"] ) ? $action_data["actionProviderId"] : "";
    $task              = isset( $action_data["task"] ) ? $action_data["task"] : "";
    $type              = isset( $params["type"] ) ? $params["type"] : "";



    $all_data = array(
        'trigger_data' => $trigger_data,
        'action_data'  => $action_data,
        'field_data'   => $field_data
    );

    global $wpdb;

    $integration_table = $wpdb->prefix . 'adfoin_integration';

    if ( $type == 'new_integration' ) {

        $result = $wpdb->insert(
            $integration_table,
            array(
                'title'           => $integration_title,
                'form_provider'   => $form_provider_id,
                'form_id'         => $form_id,
                'form_name'       => $form_name,
                'action_provider' => $action_provider,
                'task'            => $task,
                'data'            => json_encode( $all_data, true ),
                'status'          => 1
            )
        );

    }

    if ( $type == 'update_integration' ) {

        $id = esc_sql( trim( $params['edit_id'] ) );

        if ( $type != 'update_integration' &&  !empty( $id ) ) {
            exit;
        }

        $result = $wpdb->update( $integration_table,
            array(
                'title'           => $integration_title,
                'form_provider'   => $form_provider_id,
                'form_id'         => $form_id,
                'form_name'       => $form_name,
                'data'            => json_encode( $all_data, true ),
            ),
            array(
                'id' => $id
            )
        );
    }

    if ( $result ) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}

/*
 * Handles sending data to close API
 */
function adfoin_close_send_data( $record, $posted_data ) {

    $api_token    = get_option( 'adfoin_close_api_token' ) ? get_option( 'adfoin_close_api_token' ) : "";

    if( !$api_token ) {
        exit;
    }

    $record_data = json_decode( $record["data"], true );

    if( array_key_exists( "cl", $record_data["action_data"]) ) {
        if( $record_data["action_data"]["cl"]["active"] == "yes" ) {
            if( !adfoin_match_conditional_logic( $record_data["action_data"]["cl"], $posted_data ) ) {
                return;
            }
        }
    }

    $data = $record_data["field_data"];
    $task = $record["task"];

    if( $task == "add_lead" ) {
        $org_name     = empty( $data["orgName"] ) ? "" : adfoin_get_parsed_values( $data["orgName"], $posted_data );
        $org_url      = empty( $data["url"] ) ? "" : adfoin_get_parsed_values( $data["url"], $posted_data );
        $description  = empty( $data["description"] ) ? "" : adfoin_get_parsed_values( $data["description"], $posted_data );
        $contact_name = empty( $data["contactName"] ) ? "" : adfoin_get_parsed_values( $data["contactName"], $posted_data );
        $title        = empty( $data["title"] ) ? "" : adfoin_get_parsed_values( $data["title"], $posted_data );
        $email        = empty( $data["email"] ) ? "" : adfoin_get_parsed_values( $data["email"], $posted_data );
        $phone        = empty( $data["phone"] ) ? "" : adfoin_get_parsed_values( $data["phone"], $posted_data );
        $address1     = empty( $data["address1"] ) ? "" : adfoin_get_parsed_values( $data["address1"], $posted_data );
        $address2     = empty( $data["address2"] ) ? "" : adfoin_get_parsed_values( $data["address2"], $posted_data );
        $city         = empty( $data["city"] ) ? "" : adfoin_get_parsed_values( $data["city"], $posted_data );
        $zip          = empty( $data["zip"] ) ? "" : adfoin_get_parsed_values( $data["zip"], $posted_data );
        $state        = empty( $data["state"] ) ? "" : adfoin_get_parsed_values( $data["state"], $posted_data );
        $country      = empty( $data["country"] ) ? "" : adfoin_get_parsed_values( $data["country"], $posted_data );
        $url          = "https://api.close.com/api/v1/lead/";

        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode( $api_token . ':' )
        );

        $body = json_encode( array(
            "name"        => $org_name,
            "url"         => $org_url,
            "description" => $description,
            "contacts" => array(
                array(
                    "name"   => $contact_name,
                    "title"  => $title,
                    "emails" => array(
                        array(
                            "type"  => "office",
                            "email" => $email
                        )
                    ),
                    "phones" => array(
                        array(
                            "type"  => "office",
                            "phone" => $phone
                        )
                    )
                )
            ),
            "addresses" => array(
                array(
                    "label"     => "business",
                    "address_1" => $address1,
                    "address_2" => $address2,
                    "city"      => $city,
                    "state"     => $state,
                    "zipcode"   => $zip,
                    "country"   => $country
                )
            )
        ) , true );

        $args = array(
            "headers" => $headers,
            "body"    => $body
        );

        $response = wp_remote_post( $url, $args );

        adfoin_add_to_log( $response, $url, $args, $record );
    }

    return;
}