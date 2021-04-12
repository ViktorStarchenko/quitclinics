<?php

add_filter( 'adfoin_action_providers', 'adfoin_pipedrive_actions', 10, 1 );

function adfoin_pipedrive_actions( $actions ) {

    $actions['pipedrive'] = array(
        'title' => __( 'Pipedrive', 'advanced-form-integration' ),
        'tasks' => array(
            'add_ocdna'   => __( 'Create New Contact, Organization, Deal, Note, Activity', 'advanced-form-integration' )
        )
    );

    return $actions;
}

add_filter( 'adfoin_settings_tabs', 'adfoin_pipedrive_settings_tab', 10, 1 );

function adfoin_pipedrive_settings_tab( $providers ) {
    $providers['pipedrive'] = __( 'Pipedrive', 'advanced-form-integration' );

    return $providers;
}

add_action( 'adfoin_settings_view', 'adfoin_pipedrive_settings_view', 10, 1 );

function adfoin_pipedrive_settings_view( $current_tab ) {
    if( $current_tab != 'pipedrive' ) {
        return;
    }

    $nonce     = wp_create_nonce( "adfoin_pipedrive_settings" );
    $api_token = get_option( 'adfoin_pipedrive_api_token' ) ? get_option( 'adfoin_pipedrive_api_token' ) : "";
    ?>

    <form name="pipedrive_save_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
          method="post" class="container">

        <input type="hidden" name="action" value="adfoin_save_pipedrive_api_token">
        <input type="hidden" name="_nonce" value="<?php echo $nonce ?>"/>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"> <?php _e( 'API Token', 'advanced-form-integration' ); ?></th>
                <td>
                    <input type="text" name="adfoin_pipedrive_api_token"
                           value="<?php echo $api_token; ?>" placeholder="<?php _e( 'Please enter API Token', 'advanced-form-integration' ); ?>"
                           class="regular-text"/>
                    <p class="description" id="code-description"><?php _e( 'Go to Settings > Personal preferences > API to get API Token', 'advanced-form-integration' ); ?></a></p>
                </td>

            </tr>
        </table>
        <?php submit_button(); ?>
    </form>

    <?php
}

add_action( 'admin_post_adfoin_save_pipedrive_api_token', 'adfoin_save_pipedrive_api_token', 10, 0 );

function adfoin_save_pipedrive_api_token() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'adfoin_pipedrive_settings' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $api_token = sanitize_text_field( $_POST["adfoin_pipedrive_api_token"] );

    // Save tokens
    update_option( "adfoin_pipedrive_api_token", $api_token );

    advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings&tab=pipedrive" );
}

add_action( 'adfoin_add_js_fields', 'adfoin_pipedrive_js_fields', 10, 1 );

function adfoin_pipedrive_js_fields( $field_data ) {}

add_action( 'adfoin_action_fields', 'adfoin_pipedrive_action_fields', 10, 1 );

function adfoin_pipedrive_action_fields() {
    ?>
    <script type="text/template" id="pipedrive-action-template">
        <table class="form-table">
            <tr valign="top" v-if="action.task == 'add_ocdna'">
                <th scope="row">
                    <?php esc_attr_e( 'Map Fields', 'advanced-form-integration' ); ?>
                </th>
                <td scope="row">

                </td>
            </tr>

            <tr class="alternate" v-if="action.task == 'add_ocdna'">
                <td>
                    <label for="tablecell">
                        <?php esc_attr_e( 'Instructions', 'advanced-form-integration' ); ?>
                    </label>
                </td>

                <td>
                    <p><?php _e('This action will create a contact at first (required). Then Organization, Deal, Note and Activity will be created (optional, if filled)', 'advanced-form-integration' );?></p>
                </td>
            </tr>

            <tr valign="top" class="alternate" v-if="action.task == 'add_ocdna'">
                <td scope="row-title">
                    <label for="tablecell">
                        <?php esc_attr_e( 'Owner', 'advanced-form-integration' ); ?>
                    </label>
                </td>
                <td>
                    <select name="fieldData[owner]" v-model="fielddata.owner" required="required">
                        <option value=""> <?php _e( 'Select Owner...', 'advanced-form-integration' ); ?> </option>
                        <option v-for="(item, index) in fielddata.ownerList" :value="index" > {{item}}  </option>
                    </select>
                    <div class="spinner" v-bind:class="{'is-active': ownerLoading}" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></div>
                </td>
            </tr>

            <editable-field v-for="field in fields" v-bind:key="field.value" v-bind:field="field" v-bind:trigger="trigger" v-bind:action="action" v-bind:fielddata="fielddata"></editable-field>
        </table>
    </script>
    <?php
}

add_action( 'wp_ajax_adfoin_get_pipedrive_owner_list', 'adfoin_get_pipedrive_owner_list', 10, 0 );

/*
 * Get Pipedrive Owner list
 */
function adfoin_get_pipedrive_owner_list() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'advanced-form-integration' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $api_token = get_option( 'adfoin_pipedrive_api_token' ) ? get_option( 'adfoin_pipedrive_api_token' ) : "";

    if( ! $api_token ) {
        return array();
    }

    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json'
        )
    );

    $url = "https://api.pipedrive.com/v1/users?api_token=" . $api_token;

    $data      = wp_remote_request( $url, $args );

    if( is_wp_error( $data ) ) {
        wp_snd_json_error();
    }

    $body  = json_decode( $data["body"] );
    $lists = wp_list_pluck( $body->data, 'name', 'id' );

    wp_send_json_success( $lists );
}

add_action( 'wp_ajax_adfoin_get_pipedrive_org_fields', 'adfoin_get_pipedrive_org_fields', 10, 0 );

/*
 * Get Pipedrive Organization Fields
 */
function adfoin_get_pipedrive_org_fields() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'advanced-form-integration' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $api_token = get_option( 'adfoin_pipedrive_api_token' ) ? get_option( 'adfoin_pipedrive_api_token' ) : "";

    if( ! $api_token ) {
        return array();
    }

    $org_fields = array(
        array( 'key' => 'org_name', 'value' => 'Name [Organziation]', 'description' => '' ),
        array( 'key' => 'org_address', 'value' => 'Address [Organziation]', 'description' => '' ),
    );

    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json'
        )
    );

    $url = "https://api.pipedrive.com/v1/organizationFields?api_token=" . $api_token;

    $data      = wp_remote_request( $url, $args );

    if( is_wp_error( $data ) ) {
        wp_snd_json_error();
    }

    $body       = json_decode( $data["body"] );

    foreach( $body->data as $single ) {
        if( strlen( $single->key ) == 40 || $single->key == "label" ) {

            $description = "";

            if( $single->field_type == "enum" ) {
                foreach( $single->options as $value ) {
                    $description .= $value->label . ': ' . $value->id . '  ';
                }
            }

            array_push( $org_fields, array( 'key' => 'org_' . $single->key, 'value' => $single->name . ' [Organziation]', 'description' => $description ) );
        }
    }

    wp_send_json_success( $org_fields );
}

add_action( 'wp_ajax_adfoin_get_pipedrive_person_fields', 'adfoin_get_pipedrive_person_fields', 10, 0 );

/*
 * Get Pipedrive Peson Fields
 */
function adfoin_get_pipedrive_person_fields() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'advanced-form-integration' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $api_token = get_option( 'adfoin_pipedrive_api_token' ) ? get_option( 'adfoin_pipedrive_api_token' ) : "";

    if( ! $api_token ) {
        return array();
    }

    $person_fields = array(
        array( 'key' => 'per_name', 'value' => 'Name [Person]', 'description' => '' ),
        array( 'key' => 'per_email', 'value' => 'Email [Person]', 'description' => '' ),
        array( 'key' => 'per_phone', 'value' => 'Phone [Person]', 'description' => '' )
    );

    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json'
        )
    );

    $url = "https://api.pipedrive.com/v1/personFields?api_token=" . $api_token;

    $data = wp_remote_request( $url, $args );

    if( is_wp_error( $data ) ) {
        wp_send_json_success( $person_fields );
    }

    $body = json_decode( $data["body"] );

    foreach( $body->data as $single ) {
        if( strlen( $single->key ) == 40 || $single->key == "label" ) {

            $description = "";

            if( $single->field_type == "enum" ) {
                foreach( $single->options as $value ) {
                    $description .= $value->label . ': ' . $value->id . '  ';
                }
            }

            array_push( $person_fields, array( 'key' => 'per_' . $single->key, 'value' => $single->name . ' [Person]', 'description' => $description ) );
        }
    }

    wp_send_json_success( $person_fields );
}

add_action( 'wp_ajax_adfoin_get_pipedrive_deal_fields', 'adfoin_get_pipedrive_deal_fields', 10, 0 );

/*
 * Get Pipedrive Dal Fields
 */
function adfoin_get_pipedrive_deal_fields() {
    // Security Check
    if (! wp_verify_nonce( $_POST['_nonce'], 'advanced-form-integration' ) ) {
        die( __( 'Security check Failed', 'advanced-form-integration' ) );
    }

    $api_token = get_option( 'adfoin_pipedrive_api_token' ) ? get_option( 'adfoin_pipedrive_api_token' ) : "";

    if( ! $api_token ) {
        return array();
    }

    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json'
        )
    );

    $stages     = "";
    $stage_url  = "https://api.pipedrive.com/v1/stages?api_token=" . $api_token;
    $stage_data = wp_remote_request( $stage_url, $args );
    $stage_body = json_decode( $stage_data["body"] );

    foreach( $stage_body->data as $single ) {
        $stages .= $single->pipeline_name . '/' . $single->name . ': ' . $single->id . ' ';
    }

    $deal_fields = array(
        array( 'key' => 'deal_title', 'value' => 'Title [Deal]', 'description' => '' ),
        array( 'key' => 'deal_value', 'value' => 'Value [Deal]', 'description' => '' ),
        array( 'key' => 'deal_currency', 'value' => 'Currency [Deal]', 'description' => '' ),
        array( 'key' => 'deal_probability', 'value' => 'Probability [Deal]', 'description' => '' ),
        array( 'key' => 'deal_stage_id', 'value' => 'Stage ID [Deal]', 'description' => $stages ),
        array( 'key' => 'deal_status', 'value' => 'Status [Deal]', 'description' => 'Example: open, lost, won, deleted' ),
        array( 'key' => 'deal_lost_reason', 'value' => 'Lost Reason [Deal]', 'description' => '' ),
    );



    $url = "https://api.pipedrive.com/v1/dealFields?api_token=" . $api_token;

    $data = wp_remote_request( $url, $args );

    if( is_wp_error( $data ) ) {
        wp_snd_json_error();
    }

    $body = json_decode( $data["body"] );

    foreach( $body->data as $single ) {
        if( strlen( $single->key ) == 40 || $single->key == "label" ) {

            $description = "";

            if( $single->field_type == "enum" ) {
                foreach( $single->options as $value ) {
                    $description .= $value->label . ': ' . $value->id . '  ';
                }
            }

            array_push( $deal_fields, array( 'key' => 'deal_' . $single->key, 'value' => $single->name . ' [Deal]', 'description' => $description ) );
        }
    }

    wp_send_json_success( $deal_fields );
}

/*
 * Saves connection mapping
 */
function adfoin_pipedrive_save_integration() {
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
 * Handles sending data to Pipedrive API
 */
function adfoin_pipedrive_send_data( $record, $posted_data ) {

    $api_token    = get_option( 'adfoin_pipedrive_api_token' ) ? get_option( 'adfoin_pipedrive_api_token' ) : "";

    if( !$api_token ) {
        exit;
    }

    $record_data      = json_decode( $record["data"], true );

    if( array_key_exists( "cl", $record_data["action_data"] ) ) {
        if( $record_data["action_data"]["cl"]["active"] == "yes" ) {
            if( !adfoin_match_conditional_logic( $record_data["action_data"]["cl"], $posted_data ) ) {
                return;
            }
        }
    }

    $data      = $record_data["field_data"];
    $task      = $record["task"];
    $owner     = $data["owner"];
    $org_id    = "";
    $person_id = "";
    $deal_id   = "";

    if( $task == "add_ocdna" ) {

        $holder      = array();
        $org_data    = array();
        $person_data = array();
        $deal_data   = array();
        $note_data   = array();
        $act_data    = array();

        foreach( $data as $key => $value ) {
            $holder[$key] = adfoin_get_parsed_values( $data[$key], $posted_data );
        }

        foreach( $holder as $key => $value ) {
            if( substr( $key, 0, 4 ) == 'org_' && $value ) {
                $key = substr( $key, 4 );

                $org_data[$key] = $value;
            }

            if( substr( $key, 0, 4 ) == 'per_' && $value ) {
                $key = substr( $key, 4 );

                $person_data[$key] = $value;
            }

            if( substr( $key, 0, 5 ) == 'deal_' && $value ) {
                $key = substr( $key, 5 );

                $deal_data[$key] = $value;
            }

            if( substr( $key, 0, 5 ) == 'note_' && $value ) {
                $key = substr( $key, 5 );

                $note_data[$key] = $value;
            }

            if( substr( $key, 0, 4 ) == 'act_' && $value ) {
                $key = substr( $key, 4 );

                $act_data[$key] = $value;
            }
        }

        $headers = array(
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        );

        if( $org_data['name'] ) {
            $org_data["owner_id"] = $owner;

            $url = "https://api.pipedrive.com/v1/organizations?api_token={$api_token}";

            $body = json_encode( $org_data );

            $args = array(
                "headers" => $headers,
                "body"    => $body
            );

            $response = wp_remote_post( $url, $args );

            adfoin_add_to_log( $response, $url, $args, $record );

            $body = json_decode( $response["body"] );

            if( $body->success == true ) {
                $org_id = $body->data->id;
            }
        }

        if( $person_data['name'] ) {
            $person_data["owner_id"] = $owner;

            if( $org_id ) {
                $person_data['org_id'] = $org_id;
            }

            $url = "https://api.pipedrive.com/v1/persons?api_token={$api_token}";

            $body = json_encode( $person_data );

            $args = array(
                "headers" => $headers,
                "body"    => $body
            );

            $response = wp_remote_post( $url, $args );

            adfoin_add_to_log( $response, $url, $args, $record );

            $body = json_decode( $response["body"] );

            if( $body->success == true ) {
                $person_id = $body->data->id;
            }
        }

        if( $deal_data['title'] ) {
            $deal_data["user_id"] = $owner;

            if( $org_id ) {
                $deal_data['org_id'] = $org_id;
            }

            if( $person_id ) {
                $deal_data['person_id'] = $person_id;
            }

            $url = "https://api.pipedrive.com/v1/deals?api_token={$api_token}";

            $body = json_encode( $deal_data );

            $args = array(
                "headers" => $headers,
                "body"    => $body
            );

            $response = wp_remote_post( $url, $args );

            adfoin_add_to_log( $response, $url, $args, $record );

            $body = json_decode( $response["body"] );

            if( $body->success == true ) {
                $deal_id = $body->data->id;
            }
        }

        if( $note_data['content'] ) {
            $note_data["user_id"] = $owner;

            if( $org_id ) {
                $note_data['org_id'] = $org_id;
            }

            if( $person_id ) {
                $note_data['person_id'] = $person_id;
            }

            if( $deal_id ) {
                $note_data['deal_id'] = $deal_id;
            }

            $url = "https://api.pipedrive.com/v1/notes?api_token={$api_token}";

            $body = json_encode( $note_data );

            $args = array(
                "headers" => $headers,
                "body"    => $body
            );

            $response = wp_remote_post( $url, $args );

            adfoin_add_to_log( $response, $url, $args, $record );
        }

        if( $act_data['subject'] ) {
            $act_data["user_id"] = $owner;

            if( $org_id ) {
                $act_data['org_id'] = $org_id;
            }

            if( $person_id ) {
                $act_data['person_id'] = $person_id;
            }

            if( $deal_id ) {
                $act_data['deal_id'] = $deal_id;
            }

            $url = "https://api.pipedrive.com/v1/activities?api_token={$api_token}";

            $body = json_encode( $act_data );

            $args = array(
                "headers" => $headers,
                "body"    => $body
            );

            $response = wp_remote_post( $url, $args );

            adfoin_add_to_log( $response, $url, $args, $record );
        }
    }

    return;
}