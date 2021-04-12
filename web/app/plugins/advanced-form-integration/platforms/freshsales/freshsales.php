<?php

add_filter( 'adfoin_action_providers', 'adfoin_freshsales_actions', 10, 1 );

function adfoin_freshsales_actions( $actions ) {

    $actions['freshsales'] = array(
        'title' => __( 'Freshsales', 'advanced-form-integration' ),
        'tasks' => array(
            'add_lead'    => __( 'Create New Lead', 'advanced-form-integration' ),
            'add_contact' => __( 'Create New Contact', 'advanced-form-integration' )
        )
    );

    return $actions;
}

add_filter( 'adfoin_settings_tabs', 'adfoin_freshsales_settings_tab', 10, 1 );

function adfoin_freshsales_settings_tab( $providers ) {
    $providers['freshsales'] = __( 'Freshsales', 'advanced-form-integration' );

    return $providers;
}

add_action( 'adfoin_settings_view', 'adfoin_freshsales_settings_view', 10, 1 );

function adfoin_freshsales_settings_view( $current_tab ) {
    if( $current_tab != 'freshsales' ) {
        return;
    }

    $nonce     = wp_create_nonce( "adfoin_freshsales_settings" );
    $api_key   = get_option( 'adfoin_freshsales_api_key' ) ? get_option( 'adfoin_freshsales_api_key' ) : "";
    $subdomain = get_option( 'adfoin_freshsales_subdomain' ) ? get_option( 'adfoin_freshsales_subdomain' ) : "";
    ?>

    <form name="freshsales_save_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
          method="post" class="container">

        <input type="hidden" name="action" value="adfoin_save_freshsales_api_key">
        <input type="hidden" name="_nonce" value="<?php echo $nonce ?>"/>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <?php _e( 'Subdomain', 'advanced-form-integration' ); ?></th>
                <td>
                    <input type="text" name="adfoin_freshsales_subdomain"
                           value="<?php echo $subdomain; ?>" placeholder="<?php _e( 'Please enter Subdomain', 'advanced-form-integration' ); ?>"
                           class="regular-text"/>
                    <p>
                        1. This is subdomain part of Freshsales app url<br>
                        2. For example: if app url is 'https://nasirahmed.freshsales.io' <br>
                        3. Copy 'nasirahmed' and paste above
                    </p>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"> <?php _e( 'API Key', 'advanced-form-integration' ); ?></th>
                <td>
                    <input type="text" name="adfoin_freshsales_api_key"
                           value="<?php echo $api_key; ?>" placeholder="<?php _e( 'Please enter Acess Token', 'advanced-form-integration' ); ?>"
                           class="regular-text"/>
                    <p>
                        1. Go to Freshsales app <br>
                        2. Go to Settings <br>
                        3. Go to API SETTINGS <br>
                        4. Copy API Key and paste above
                    </p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>

    <?php
}

add_action( 'admin_post_adfoin_save_freshsales_api_key', 'adfoin_save_freshsales_api_key', 10, 0 );

function adfoin_save_freshsales_api_key() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'adfoin_freshsales_settings' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $api_key   = sanitize_text_field( $_POST["adfoin_freshsales_api_key"] );
    $subdomain = sanitize_text_field( $_POST["adfoin_freshsales_subdomain"] );

    // Save tokens
    update_option( "adfoin_freshsales_api_key", $api_key );
    update_option( "adfoin_freshsales_subdomain", $subdomain );

    advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings&tab=freshsales" );
}

add_action( 'adfoin_add_js_fields', 'adfoin_freshsales_js_fields', 10, 1 );

function adfoin_freshsales_js_fields( $field_data ) {}

add_action( 'adfoin_action_fields', 'adfoin_freshsales_action_fields' );

function adfoin_freshsales_action_fields() {
    ?>
    <script type="text/template" id="freshsales-action-template">
        <table class="form-table">
            <tr valign="top" v-if="action.task == 'add_contact'">
                <th scope="row">
                    <?php esc_attr_e( 'Contact Fields', 'advanced-form-integration' ); ?>
                </th>
                <td scope="row">

                </td>
            </tr>
            <tr valign="top" v-if="action.task == 'add_lead'">
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
function adfoin_freshsales_save_integration() {
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
 * Handles sending data to Freshsales API
 */
function adfoin_freshsales_send_data( $record, $posted_data ) {

    $api_key   = get_option( 'adfoin_freshsales_api_key' ) ? get_option( 'adfoin_freshsales_api_key' ) : "";
    $subdomain = get_option( 'adfoin_freshsales_subdomain' ) ? get_option( 'adfoin_freshsales_subdomain' ) : "";

    if( !$api_key || !$subdomain ) {
        exit;
    }

    $record_data = json_decode( $record["data"], true );

    if( array_key_exists( "cl", $record_data["action_data"] ) ) {
        if( $record_data["action_data"]["cl"]["active"] == "yes" ) {
            if( !adfoin_match_conditional_logic( $record_data["action_data"]["cl"], $posted_data ) ) {
                return;
            }
        }
    }

    $data       = $record_data["field_data"];
    $task       = $record["task"];
    $email      = empty( $data["email"] ) ? "" : adfoin_get_parsed_values( $data["email"], $posted_data );
    $first_name = empty( $data["firstName"] ) ? "" : adfoin_get_parsed_values( $data["firstName"], $posted_data );
    $last_name  = empty( $data["lastName"] ) ? "" : adfoin_get_parsed_values( $data["lastName"], $posted_data );

    if( $task == "add_contact" ) {

        $headers = array(
            "Authorization" => "Token token=\"{$api_key}\"",
            "Content-Type"  => "application/json"
        );

        $url = "https://{$subdomain}.freshsales.io/api/contacts";

        $body = array(
            "contact" => array(
                "first_name" => $first_name,
                "last_name"  => $last_name,
                "email"      => $email
            )
        );

        $args = array(
            "headers" => $headers,
            "body" => json_encode( $body )
        );

        $response = wp_remote_post( $url, $args );
    }

    if( $task == "add_lead" ) {

        $headers = array(
            "Authorization" => "Token token=\"{$api_key}\"",
            "Content-Type"  => "application/json"
        );

        $url = "https://{$subdomain}.freshsales.io/api/leads";

        $body = array(
            "lead" => array(
                "first_name" => $first_name,
                "last_name"  => $last_name,
                "email"      => $email
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