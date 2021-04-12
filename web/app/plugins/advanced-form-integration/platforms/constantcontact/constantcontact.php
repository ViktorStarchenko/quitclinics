<?php

class ADFOIN_ConstantContact extends Advanced_Form_Integration_OAuth2 {

    const service_name           = 'constant_contact';
    const authorization_endpoint = 'https://api.cc.email/v3/idfed';
    const token_endpoint         = 'https://idfed.constantcontact.com/as/token.oauth2';
    const refresh_token_endpoint = 'https://idfed.constantcontact.com/as/token.oauth2';

    private static $instance;
    protected      $contact_lists = [ ];

    public static function get_instance() {

        if ( empty( self::$instance ) ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    private function __construct() {

        $this->authorization_endpoint = self::authorization_endpoint;
        $this->token_endpoint         = self::token_endpoint;

        $option = (array) maybe_unserialize( get_option( 'adfoin_constantcontact_keys' ) );

        if ( isset( $option['client_id'] ) ) {
            $this->client_id = $option['client_id'];
        }

        if ( isset( $option['client_secret'] ) ) {
            $this->client_secret = $option['client_secret'];
        }

        if ( isset( $option['access_token'] ) ) {
            $this->access_token = $option['access_token'];
        }

        if ( isset( $option['refresh_token'] ) ) {
            $this->refresh_token = $option['refresh_token'];
        }

        if ( $this->is_active() ) {
            if ( isset( $option['contact_lists'] ) ) {
                $this->contact_lists = $option['contact_lists'];
            }
        }

        add_action( 'admin_init', array( $this, 'auth_redirect' ) );
        add_filter( 'adfoin_action_providers', array( $this, 'adfoin_constantcontact_actions' ), 10, 1 );
        add_filter( 'adfoin_settings_tabs', array( $this, 'adfoin_constantcontact_settings_tab' ), 10, 1 );
        add_action( 'adfoin_settings_view', array( $this, 'adfoin_constantcontact_settings_view' ), 10, 1 );
        add_action( 'admin_post_adfoin_save_constantcontact_keys', array( $this, 'adfoin_save_constantcontact_keys' ), 10, 0 );
        add_action( 'adfoin_action_fields', array( $this, 'action_fields' ), 10, 1 );
        add_action( 'wp_ajax_adfoin_get_constantcontact_list', array( $this, 'get_constantcontact_list' ), 10, 0 );
        add_action( "rest_api_init", array( $this, "create_webhook_route" ) );
    }

    public function create_webhook_route() {
        register_rest_route( 'advancedformintegration', '/constantcontact',
            array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'get_webhook_data' ),
                'permission_callback' => '__return_true'
            )
        );
    }

    public function get_webhook_data( $request ) {
        $params = $request->get_params();

        $code = isset( $params['code'] ) ? trim( $params['code'] ) : '';

        if ( $code ) {

            $redirect_to = add_query_arg(
                [
                    'service' => 'authorize',
                    'action'  => 'adfoin_constantcontact_auth_redirect',
                    'code'    => $code,
                ],
                admin_url( 'admin.php?page=advanced-form-integration')
            );

            wp_safe_redirect( $redirect_to );
            exit();
        }
    }

    public function adfoin_constantcontact_actions( $actions ) {

        $actions['constantcontact'] = array(
            'title' => __( 'Constant Contact', 'advanced-form-integration' ),
            'tasks' => array(
                'subscribe'   => __( 'Subscribe To List', 'advanced-form-integration' )
            )
        );

        return $actions;
    }

    public function adfoin_constantcontact_settings_tab( $providers ) {
        $providers['constantcontact'] = __( 'Constant Contact', 'advanced-form-integration' );

        return $providers;
    }

    public function adfoin_constantcontact_settings_view( $current_tab ) {
        if( $current_tab != 'constantcontact' ) {
            return;
        }

        $option       = (array) maybe_unserialize( get_option( 'adfoin_constantcontact_keys' ) );
        $nonce        = wp_create_nonce( "adfoin_constantcontact_settings" );
        $api_key      = $option['client_id'];
        $api_secret   = $option['client_secret'];
        $redirect_uri = $this->get_redirect_uri();
        ?>

        <form name="constantcontact_save_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
              method="post" class="container">

            <input type="hidden" name="action" value="adfoin_save_constantcontact_keys">
            <input type="hidden" name="_nonce" value="<?php echo $nonce ?>"/>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Status', 'advanced-form-integration' ); ?></th>
                    <td>
                        <?php
                        if( $this->is_active() ) {
                            _e( 'Connected', 'advanced-form-integration' );
                        } else {
                            _e( 'Not Connected', 'advanced-form-integration' );
                        }
                        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'API Key', 'advanced-form-integration' ); ?></th>
                    <td>
                        <input type="text" name="adfoin_constantcontact_api_key"
                               value="<?php echo $api_key; ?>" placeholder="<?php _e( 'Enter API Key', 'advanced-form-integration' ); ?>"
                               class="regular-text"/>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'API Secret', 'advanced-form-integration' ); ?></th>
                    <td>
                        <input type="text" name="adfoin_constantcontact_api_secret"
                               value="<?php echo $api_secret; ?>" placeholder="<?php _e( 'Enter API Secret', 'advanced-form-integration' ); ?>"
                               class="regular-text"/>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Redirect URI', 'advanced-form-integration' ); ?></th>
                    <td>
                        <input type="text" value="<?php echo $redirect_uri; ?>" id="redirect_uri" name="redirect_uri" class="regular-text code" readonly="readonly" onfocus="this.select();" />
                    </td>
                </tr>
            </table>
            <?php submit_button( __( 'Authorize', 'advanced-form-integration' ) ); ?>
        </form>

        <?php
    }

    public function adfoin_save_constantcontact_keys() {
        // Security Check
        if (! wp_verify_nonce( $_POST['_nonce'], 'adfoin_constantcontact_settings' ) ) {
            die( __( 'Security check Failed', 'advanced-form-integration' ) );
        }

        $api_key    = isset( $_POST["adfoin_constantcontact_api_key"] ) ? sanitize_text_field( $_POST["adfoin_constantcontact_api_key"] ) : "";
        $api_secret = isset( $_POST["adfoin_constantcontact_api_secret"] ) ? sanitize_text_field( $_POST["adfoin_constantcontact_api_secret"] ) : "";

        $this->client_id     = trim( $api_key );
        $this->client_secret = trim( $api_secret );

        $this->save_data();
        $this->authorize( 'contact_data' );

        advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings&tab=constantcontact" );
    }

    public function action_fields() {
        ?>
        <script type="text/template" id="constantcontact-action-template">
            <table class="form-table">
                <tr valign="top" v-if="action.task == 'subscribe'">
                    <th scope="row">
                        <?php esc_attr_e( 'Map Fields', 'advanced-form-integration' ); ?>
                    </th>
                    <td scope="row">

                    </td>
                </tr>

                <tr valign="top" class="alternate" v-if="action.task == 'subscribe'">
                    <td scope="row-title">
                        <label for="tablecell">
                            <?php esc_attr_e( 'Constant Contact List', 'advanced-form-integration' ); ?>
                        </label>
                    </td>
                    <td>
                        <select name="fieldData[listId]" v-model="fielddata.listId" required="required">
                            <option value=""> <?php _e( 'Select List...', 'advanced-form-integration' ); ?> </option>
                            <option v-for="(item, index) in fielddata.list" :value="index" > {{item}}  </option>
                        </select>
                        <div class="spinner" v-bind:class="{'is-active': listLoading}" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></div>
                    </td>
                </tr>

                <editable-field v-for="field in fields" v-bind:key="field.value" v-bind:field="field" v-bind:trigger="trigger" v-bind:action="action" v-bind:fielddata="fielddata"></editable-field>
            </table>
        </script>


        <?php
    }

    public function auth_redirect() {

        $auth   = isset( $_GET['auth'] ) ? trim( $_GET['auth'] ) : '';
        $code   = isset( $_GET['code'] ) ? trim( $_GET['code'] ) : '';
        $action = isset( $_GET['action'] ) ? trim( $_GET['action'] ) : '';

        if ( 'adfoin_constantcontact_auth_redirect' == $action ) {
            $code = isset( $_GET['code'] ) ? $_GET['code'] : '';

            if ( $code ) {
                $this->request_token( $code );
            }

            if ( ! empty( $this->access_token ) ) {
                $message = 'success';
            } else {
                $message = 'failed';
            }

            wp_safe_redirect( admin_url( 'admin.php?page=advanced-form-integration-settings&tab=constantcontact' ) );

            exit();
        }
    }

    protected function save_data() {

        $data = (array) maybe_unserialize( get_option( 'adfoin_constantcontact_keys' ) );

        $option = array_merge(
            $data,
            array(
                'client_id'     => $this->client_id,
                'client_secret' => $this->client_secret,
                'access_token'  => $this->access_token,
                'refresh_token' => $this->refresh_token,
                'contact_lists' => $this->contact_lists,
            )
        );

        update_option( 'adfoin_constantcontact_keys', maybe_serialize( $option ) );
    }

    protected function reset_data() {

        $this->client_id     = '';
        $this->client_secret = '';
        $this->access_token  = '';
        $this->refresh_token = '';
        $this->contact_lists = [ ];

        $this->save_data();
    }

    protected function get_redirect_uri() {

        return site_url( '/wp-json/advancedformintegration/constantcontact' );
    }

    public function email_exists( $email ) {

        $endpoint = add_query_arg(
            [ 'email' => $email ],
            'https://api.cc.email/v3/contacts'
        );

        $request = [
            'method'  => 'GET',
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        ];

        $response = $this->remote_request( $endpoint, $request );

        if ( 400 <= (int) wp_remote_retrieve_response_code( $response ) ) {
            if ( WP_DEBUG ) {
                $this->log( $endpoint, $request, $response );
            }

            return false;
        }

        $response_body = wp_remote_retrieve_body( $response );

        if ( empty( $response_body ) ) {
            return false;
        }

        $response_body = json_decode( $response_body, true );

        return !empty( $response_body['contacts'] );
    }

    public function create_contact( $properties ) {

        $endpoint = 'https://api.cc.email/v3/contacts';

        $request = [
            'method'  => 'POST',
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
            'body'    => json_encode( $properties ),
        ];

        $response = $this->remote_request( $endpoint, $request );

        return $response;
    }

    public function get_constantcontact_list() {
        // Security Check
        if (! wp_verify_nonce( $_POST['_nonce'], 'advanced-form-integration' ) ) {
            die( __( 'Security check Failed', 'advanced-form-integration' ) );
        }

        $this->get_contact_lists();
    }

    public function get_contact_lists() {

        $endpoint = 'https://api.cc.email/v3/contact_lists';

        $request = [
            'method'  => 'GET',
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        ];

        $response = $this->remote_request( $endpoint, $request );

        if ( 400 <= (int) wp_remote_retrieve_response_code( $response ) ) {
            if ( WP_DEBUG ) {
//                $this->log( $endpoint, $request, $response );
            }

            return false;
        }

        $response_body = wp_remote_retrieve_body( $response );

        if ( empty( $response_body ) ) {
            return false;
        }

        $response_body = json_decode( $response_body, true );

        if ( !empty( $response_body['lists'] ) ) {
            $lists = wp_list_pluck( $response_body['lists'], 'name', 'list_id' );

            wp_send_json_success( $lists );
        } else {
            wp_send_json_error();
        }
    }

    public function update_contact_lists( $selection = [ ] ) {

        $contact_lists        = [ ];
        $contact_lists_on_api = $this->get_contact_lists();

        if ( false !== $contact_lists_on_api ) {
            foreach ( (array) $contact_lists_on_api as $list ) {
                if ( isset( $list['list_id'] ) ) {
                    $list_id = trim( $list['list_id'] );
                } else {
                    continue;
                }

                if ( isset( $this->contact_lists[$list_id]['selected'] ) ) {
                    $list['selected'] = $this->contact_lists[$list_id]['selected'];
                } else {
                    $list['selected'] = [ ];
                }

                $contact_lists[$list_id] = $list;
            }
        } else {
            $contact_lists = $this->contact_lists;
        }

        foreach ( (array) $selection as $key => $ids_or_names ) {
            foreach ( $contact_lists as $list_id => $list ) {
                if ( in_array( $list['list_id'], (array) $ids_or_names, true )
                    or in_array( $list['name'], (array) $ids_or_names, true )
                ) {
                    $contact_lists[$list_id]['selected'][$key] = true;
                } else {
                    unset( $contact_lists[$list_id]['selected'][$key] );
                }
            }
        }

        $this->contact_lists = $contact_lists;

        if ( $selection ) {
            $this->save_data();
        }

        return $this->contact_lists;
    }
}

$constantcontact = ADFOIN_ConstantContact::get_instance();

/*
 * Saves connection mapping
 */
function adfoin_constantcontact_save_integration() {
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
 * Handles sending data to Constant Contact API
 */
function adfoin_constantcontact_send_data( $record, $posted_data ) {

    $record_data = json_decode( $record["data"], true );

    if( array_key_exists( "cl", $record_data["action_data"] ) ) {
        if( $record_data["action_data"]["cl"]["active"] == "yes" ) {
            if( !adfoin_match_conditional_logic( $record_data["action_data"]["cl"], $posted_data ) ) {
                return;
            }
        }
    }

    $data    = $record_data["field_data"];
    $list_id = $data["listId"];
    $task    = $record["task"];


    if( $task == "subscribe" ) {
        $email   = empty( $data["email"] ) ? "" : adfoin_get_parsed_values( $data["email"], $posted_data );
        $first_name   = empty( $data["firstName"] ) ? "" : adfoin_get_parsed_values($data["firstName"], $posted_data);
        $last_name    = empty( $data["lastName"] ) ? "" : adfoin_get_parsed_values($data["lastName"], $posted_data);

        $properties = array(
            "email_address"  => array(
                "address" => $email
            ),
            "first_name"    => $first_name,
            "last_name"     => $last_name,
            "create_source" => "Account"
        );

        $constantcontact = ADFOIN_ConstantContact::get_instance();
        $return = $constantcontact->create_contact( $properties );

        adfoin_add_to_log( $return, 'https://api.cc.email/v3/contacts', $properties, $record );

    }

    return;
}