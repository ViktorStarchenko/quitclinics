<?php

add_filter( 'adfoin_action_providers', 'adfoin_copper_actions', 10, 1 );

function adfoin_copper_actions( $actions ) {

    $actions['copper'] = array(
        'title' => __( 'Copper', 'advanced-form-integration' ),
        'tasks' => array(
            'add_contact'   => __( 'Create New Contact', 'advanced-form-integration' )
        )
    );

    return $actions;
}

add_filter( 'adfoin_settings_tabs', 'adfoin_copper_settings_tab', 10, 1 );

function adfoin_copper_settings_tab( $providers ) {
    $providers['copper'] = __( 'Copper', 'advanced-form-integration' );

    return $providers;
}

add_action( 'adfoin_settings_view', 'adfoin_copper_settings_view', 10, 1 );

function adfoin_copper_settings_view( $current_tab ) {
    if( $current_tab != 'copper' ) {
        return;
    }

    $nonce     = wp_create_nonce( "adfoin_copper_settings" );
    $user_email   = get_option( 'adfoin_copper_user_email' ) ? get_option( 'adfoin_copper_user_email' ) : "";
    $access_token = get_option( 'adfoin_copper_access_token' ) ? get_option( 'adfoin_copper_access_token' ) : "";
    ?>

    <form name="copper_save_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
          method="post" class="container">

        <input type="hidden" name="action" value="adfoin_save_copper_api_key">
        <input type="hidden" name="_nonce" value="<?php echo $nonce ?>"/>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <?php _e( 'User Email', 'advanced-form-integration' ); ?></th>
                <td>
                    <input type="text" name="adfoin_copper_user_email"
                           value="<?php echo $user_email; ?>" placeholder="<?php _e( 'Please enter User Email', 'advanced-form-integration' ); ?>"
                           class="regular-text"/>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"> <?php _e( 'Access Token', 'advanced-form-integration' ); ?></th>
                <td>
                    <input type="text" name="adfoin_copper_access_token"
                           value="<?php echo $access_token; ?>" placeholder="<?php _e( 'Please enter Access Token', 'advanced-form-integration' ); ?>"
                           class="regular-text"/>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>

    <?php
}

add_action( 'admin_post_adfoin_save_copper_api_key', 'adfoin_save_copper_api_key', 10, 0 );

function adfoin_save_copper_api_key() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'adfoin_copper_settings' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $user_email   = sanitize_text_field( $_POST["adfoin_copper_user_email"] );
    $access_token = sanitize_text_field( $_POST["adfoin_copper_access_token"] );

    // Save tokens
    update_option( "adfoin_copper_user_email", $user_email );
    update_option( "adfoin_copper_access_token", $access_token );

    advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings&tab=copper" );
}

add_action( 'adfoin_add_js_fields', 'adfoin_copper_js_fields', 10, 1 );

function adfoin_copper_js_fields( $field_data ) {}

add_action( 'adfoin_action_fields', 'adfoin_copper_action_fields' );

function adfoin_copper_action_fields() {
    ?>
    <script type="text/template" id="copper-action-template">
        <table class="form-table">
            <tr valign="top" v-if="action.task == 'add_contact'">
                <th scope="row">
                    <?php esc_attr_e( 'Contact Fields', 'advanced-form-integration' ); ?>
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
function adfoin_copper_save_integration() {
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
 * Handles sending data to Copper API
 */
function adfoin_copper_send_data( $record, $posted_data ) {

    $user_email   = get_option( 'adfoin_copper_user_email' ) ? get_option( 'adfoin_copper_user_email' ) : "";
    $access_token = get_option( 'adfoin_copper_access_token' ) ? get_option( 'adfoin_copper_access_token' ) : "";

    if( !$user_email || !$access_token ) {
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

    if( $task == "add_contact" ) {
        $email      = empty( $data["email"] ) ? "" : adfoin_get_parsed_values( $data["email"], $posted_data );
        $name = empty( $data["name"] ) ? "" : adfoin_get_parsed_values( $data["name"], $posted_data );

        $headers = array(
            "X-PW-AccessToken" => $access_token,
            "X-PW-Application" => "developer_api",
            "X-PW-UserEmail"   => $user_email,
            "Content-Type"     => "application/json"
        );

        $url = "https://api.prosperworks.com/developer_api/v1/people";

        $body = array(
            "name" => $name,
            "emails" => array(
                array(
                    "email" => $email,
                    "category" => "work"
                )
            )
        );

        $args = array(
            "headers" => $headers,
            "body" => json_encode( $body )
        );

        $response = wp_remote_post( $url, $args );

        adfoin_add_to_log( $response, $url, $args, $record );
    }

    return;
}