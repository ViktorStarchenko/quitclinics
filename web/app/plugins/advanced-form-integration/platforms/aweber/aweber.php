<?php

class ADFOIN_Aweber extends Advanced_Form_Integration_OAuth2
{
    const  service_name = 'aweber' ;
    const  authorization_endpoint = 'https://auth.aweber.com/oauth2/authorize' ;
    const  token_endpoint = 'https://auth.aweber.com/oauth2/token' ;
    private static  $instance ;
    protected  $code_verifier = "" ;
    protected  $code_challenge = "" ;
    protected  $auth_code = "" ;
    protected  $client_id = "wG9E9E4PVpfA0ax93gvmlsUIhWrpH00U" ;
    protected  $access_token = "" ;
    protected  $refresh_token = "" ;
    public static function get_instance()
    {
        if ( empty(self::$instance) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        $this->authorization_endpoint = self::authorization_endpoint;
        $this->token_endpoint = self::token_endpoint;
        $option = (array) maybe_unserialize( get_option( 'adfoin_aweber_keys' ) );
        if ( isset( $option['auth_code'] ) ) {
            $this->auth_code = $option['auth_code'];
        }
        if ( isset( $option['code_verifier'] ) ) {
            $this->code_verifier = $option['code_verifier'];
        }
        if ( isset( $option['code_challenge'] ) ) {
            $this->code_challenge = $option['code_challenge'];
        }
        if ( isset( $option['auth_token'] ) ) {
            $this->access_token = $option['auth_token'];
        }
        if ( isset( $option['refresh_token'] ) ) {
            $this->refresh_token = $option['refresh_token'];
        }
        if ( isset( $option['access_token'] ) ) {
            $this->access_token = $option['access_token'];
        }
        add_filter(
            'adfoin_action_providers',
            array( $this, 'adfoin_aweber_actions' ),
            10,
            1
        );
        add_filter(
            'adfoin_settings_tabs',
            array( $this, 'adfoin_aweber_settings_tab' ),
            10,
            1
        );
        add_action(
            'adfoin_settings_view',
            array( $this, 'adfoin_aweber_settings_view' ),
            10,
            1
        );
        add_action(
            'admin_post_adfoin_save_aweber_keys',
            array( $this, 'adfoin_save_aweber_keys' ),
            10,
            0
        );
        add_action(
            'adfoin_action_fields',
            array( $this, 'action_fields' ),
            10,
            1
        );
        add_action(
            'wp_ajax_adfoin_get_aweber_accounts',
            array( $this, 'get_aweber_accounts' ),
            10,
            0
        );
        add_action(
            'wp_ajax_adfoin_get_aweber_lists',
            array( $this, 'get_aweber_lists' ),
            10,
            0
        );
        add_action( "rest_api_init", array( $this, "create_webhook_route" ) );
    }
    
    public function generate_pkce_hashes()
    {
        $verifier_bytes = random_bytes( 64 );
        $code_verifier = rtrim( strtr( base64_encode( $verifier_bytes ), "+/", "-_" ), "=" );
        $challenge_bytes = hash( "sha256", $code_verifier, true );
        $code_challenge = rtrim( strtr( base64_encode( $challenge_bytes ), "+/", "-_" ), "=" );
        $this->code_verifier = $code_verifier;
        $this->code_challenge = $code_challenge;
    }
    
    public function create_webhook_route()
    {
        register_rest_route( 'advancedformintegration', '/aweber', array(
            'methods'             => 'GET',
            'callback'            => array( $this, 'get_webhook_data' ),
            'permission_callback' => '__return_true',
        ) );
    }
    
    public function adfoin_aweber_actions( $actions )
    {
        $actions['aweber'] = array(
            'title' => __( 'Aweber', 'advanced-form-integration' ),
            'tasks' => array(
            'subscribe' => __( 'Subscribe To List', 'advanced-form-integration' ),
        ),
        );
        return $actions;
    }
    
    public function adfoin_aweber_settings_tab( $providers )
    {
        $providers['aweber'] = __( 'Aweber', 'advanced-form-integration' );
        return $providers;
    }
    
    public function adfoin_aweber_settings_view( $current_tab )
    {
        if ( $current_tab != 'aweber' ) {
            return;
        }
        $this->generate_pkce_hashes();
        $option = (array) maybe_unserialize( get_option( 'adfoin_aweber_keys' ) );
        $auth_code = ( isset( $option['auth_code'] ) ? $option['auth_code'] : "" );
        $nonce = wp_create_nonce( "adfoin_aweber_settings" );
        $redirect_uri = "urn:ietf:wg:oauth:2.0:oob";
        $scope = "subscriber.write subscriber.read account.read list.read";
        $url = "https://auth.aweber.com/oauth2/authorize?response_type=code&client_id=" . $this->client_id . "&redirect_uri=" . $redirect_uri . "&scope=" . $scope . "&state=" . $nonce . "&code_challenge=" . $this->code_challenge . "&code_challenge_method=S256";
        ?>

        <form name="aweber_save_form" action="<?php 
        echo  esc_url( admin_url( 'admin-post.php' ) ) ;
        ?>"
              method="post" class="container">

            <input type="hidden" name="action" value="adfoin_save_aweber_keys">
            <input type="hidden" name="_nonce" value="<?php 
        echo  $nonce ;
        ?>"/>

            <table class="form-table">

                <tr valign="top">
                    <th scope="row"> <?php 
        _e( 'Status', 'advanced-form-integration' );
        ?></th>
                    <td>
                        <?php 
        
        if ( $this->is_active() ) {
            _e( 'Connected', 'advanced-form-integration' );
        } else {
            _e( 'Not Connected', 'advanced-form-integration' );
        }
        
        ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php 
        _e( 'Authorization Code', 'advanced-form-integration' );
        ?></th>
                    <td>
                        <input type="hidden" name="adfoin_aweber_code_verifier" value="<?php 
        echo  $this->code_verifier ;
        ?>" />
                        <input type="hidden" name="adfoin_aweber_code_challenge" value="<?php 
        echo  $this->code_challenge ;
        ?>" />
                        <input type="text" name="adfoin_aweber_auth_code"
                               value="<?php 
        echo  $auth_code ;
        ?>" placeholder="<?php 
        _e( 'Enter Authorization Code', 'advanced-form-integration' );
        ?>"
                               class="regular-text"/>
                        <p class="description" id="code-description"><a
                                href="<?php 
        echo  esc_url( $url ) ;
        ?>"
                                target="_blank" rel="noopener noreferrer"><?php 
        _e( 'Click here to get the code', 'advanced-form-integration' );
        ?></a></p>
                    </td>
                </tr>

            </table>
            <?php 
        submit_button( __( 'Save', 'advanced-form-integration' ) );
        ?>
        </form>

        <?php 
    }
    
    public function adfoin_save_aweber_keys()
    {
        // Security Check
        if ( !wp_verify_nonce( $_POST['_nonce'], 'adfoin_aweber_settings' ) ) {
            die( __( 'Security check Failed', 'advanced-form-integration' ) );
        }
        $auth_code = ( isset( $_POST["adfoin_aweber_auth_code"] ) ? trim( sanitize_text_field( $_POST["adfoin_aweber_auth_code"] ) ) : "" );
        $code_verifier = ( isset( $_POST["adfoin_aweber_code_verifier"] ) ? trim( sanitize_text_field( $_POST["adfoin_aweber_code_verifier"] ) ) : "" );
        $code_challenge = ( isset( $_POST["adfoin_aweber_code_challenge"] ) ? trim( sanitize_text_field( $_POST["adfoin_aweber_code_challenge"] ) ) : "" );
        
        if ( $auth_code ) {
            $this->auth_code = $auth_code;
            $this->code_verifier = $code_verifier;
            $this->code_challenge = $code_challenge;
            $this->save_data();
            $this->request_token( $auth_code );
        } else {
            $this->reset_data();
        }
        
        advanced_form_integration_redirect( "admin.php?page=advanced-form-integration-settings&tab=aweber" );
    }
    
    protected function request_token( $authorization_code )
    {
        $endpoint = add_query_arg( array(
            'code'          => $authorization_code,
            'client_id'     => $this->client_id,
            'code_verifier' => $this->code_verifier,
            'grant_type'    => 'authorization_code',
        ), $this->token_endpoint );
        $request = array(
            'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
        );
        $response = wp_remote_post( $endpoint, $request );
        $response_code = (int) wp_remote_retrieve_response_code( $response );
        $response_body = wp_remote_retrieve_body( $response );
        $response_body = json_decode( $response_body, true );
        
        if ( 200 != $response_code ) {
            // Unauthorized
            $this->access_token = null;
            $this->refresh_token = null;
        } else {
            
            if ( isset( $response_body['access_token'] ) ) {
                $this->access_token = $response_body['access_token'];
            } else {
                $this->access_token = null;
            }
            
            
            if ( isset( $response_body['refresh_token'] ) ) {
                $this->refresh_token = $response_body['refresh_token'];
            } else {
                $this->refresh_token = null;
            }
        
        }
        
        $this->save_data();
        return $response;
    }
    
    public function action_fields()
    {
        ?>
        <script type="text/template" id="aweber-action-template">
            <table class="form-table">
                <tr valign="top" v-if="action.task == 'subscribe'">
                    <th scope="row">
                        <?php 
        esc_attr_e( 'Map Fields', 'advanced-form-integration' );
        ?>
                    </th>
                    <td scope="row">

                    </td>
                </tr>

                <tr valign="top" class="alternate" v-if="action.task == 'subscribe'">
                    <td scope="row-title">
                        <label for="tablecell">
                            <?php 
        esc_attr_e( 'Aweber Account', 'advanced-form-integration' );
        ?>
                        </label>
                    </td>
                    <td>
                        <select name="fieldData[accountId]" v-model="fielddata.accountId" @change="getLists" required="required">
                            <option value=""> <?php 
        _e( 'Select Account...', 'advanced-form-integration' );
        ?> </option>
                            <option v-for="(item, index) in fielddata.accounts" :value="index" > {{item}}  </option>
                        </select>
                        <div class="spinner" v-bind:class="{'is-active': accountLoading}" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></div>
                    </td>
                </tr>

                <tr valign="top" class="alternate" v-if="action.task == 'subscribe'">
                    <td scope="row-title">
                        <label for="tablecell">
                            <?php 
        esc_attr_e( 'Aweber List', 'advanced-form-integration' );
        ?>
                        </label>
                    </td>
                    <td>
                        <select name="fieldData[listId]" v-model="fielddata.listId" required="required">
                            <option value=""> <?php 
        _e( 'Select List...', 'advanced-form-integration' );
        ?> </option>
                            <option v-for="(item, index) in fielddata.lists" :value="index" > {{item}}  </option>
                        </select>
                        <div class="spinner" v-bind:class="{'is-active': listLoading}" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;"></div>
                    </td>
                </tr>

                <editable-field v-for="field in fields" v-bind:key="field.value" v-bind:field="field" v-bind:trigger="trigger" v-bind:action="action" v-bind:fielddata="fielddata"></editable-field>
                <?php 
        
        if ( adfoin_fs()->is_not_paying() ) {
            ?>
                    <tr valign="top" v-if="action.task == 'subscribe'">
                        <th scope="row">
                            <?php 
            esc_attr_e( 'Go Pro', 'advanced-form-integration' );
            ?>
                        </th>
                        <td scope="row">
                            <span><?php 
            printf( __( 'To unlock custom fields and tags consider <a href="%s">upgrading to Pro</a>.', 'advanced-form-integration' ), admin_url( 'admin.php?page=advanced-form-integration-settings-pricing' ) );
            ?></span>
                        </td>
                    </tr>
                    <?php 
        }
        
        ?>
                
            </table>
        </script>


        <?php 
    }
    
    protected function save_data()
    {
        $data = (array) maybe_unserialize( get_option( 'adfoin_aweber_keys' ) );
        $option = array_merge( $data, array(
            'client_id'      => $this->client_id,
            'auth_code'      => $this->auth_code,
            'code_challenge' => $this->code_challenge,
            'code_verifier'  => $this->code_verifier,
            'access_token'   => $this->access_token,
            'refresh_token'  => $this->refresh_token,
        ) );
        update_option( 'adfoin_aweber_keys', maybe_serialize( $option ) );
    }
    
    protected function get_http_authorization_header( $scheme = 'basic' )
    {
        $scheme = strtolower( trim( $scheme ) );
        switch ( $scheme ) {
            case 'bearer':
                return sprintf( 'Bearer %s', $this->access_token );
            case 'basic':
            default:
                return sprintf( 'Basic %s', base64_encode( $this->client_id . ':' . $this->client_secret ) );
        }
    }
    
    protected function reset_data()
    {
        $this->client_id = '';
        $this->auth_code = '';
        $this->code_challenge = '';
        $this->code_verifier = '';
        $this->access_token = '';
        $this->refresh_token = '';
        $this->save_data();
    }
    
    public function create_contact(
        $properties,
        $account_id,
        $list_id,
        $record = array()
    )
    {
        $endpoint = "https://api.aweber.com/1.0/accounts/{$account_id}/lists/{$list_id}/subscribers";
        $request = [
            'method'  => 'POST',
            'headers' => [
            'Content-Type' => 'application/json',
        ],
            'body'    => json_encode( $properties ),
        ];
        $response = $this->remote_request( $endpoint, $request );
        adfoin_add_to_log(
            $response,
            $endpoint,
            $request,
            $record
        );
        return $response;
    }
    
    protected function remote_request( $url, $request = array() )
    {
        $refreshed = false;
        $request = wp_parse_args( $request, [] );
        $request['headers'] = array_merge( $request['headers'], array(
            'Authorization' => $this->get_http_authorization_header( 'bearer' ),
        ) );
        $response = wp_remote_request( esc_url_raw( $url ), $request );
        
        if ( 401 === wp_remote_retrieve_response_code( $response ) and !$refreshed ) {
            $this->refresh_token();
            $refreshed = true;
            $response = $this->remote_request( $url, $request );
        }
        
        return $response;
    }
    
    public function get_aweber_accounts()
    {
        $endpoint = 'https://api.aweber.com/1.0/accounts';
        $request = array(
            'method'  => 'GET',
            'headers' => array(
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ),
        );
        $response = $this->remote_request( $endpoint, $request );
        if ( 400 <= (int) wp_remote_retrieve_response_code( $response ) ) {
            wp_send_json_error();
        }
        $response_body = wp_remote_retrieve_body( $response );
        if ( empty($response_body) ) {
            wp_send_json_error();
        }
        $response_body = json_decode( $response_body, true );
        
        if ( !empty($response_body['entries']) ) {
            $accounts = wp_list_pluck( $response_body['entries'], 'id', 'id' );
            wp_send_json_success( $accounts );
        } else {
            wp_send_json_error();
        }
    
    }
    
    protected function refresh_token()
    {
        $endpoint = add_query_arg( array(
            'refresh_token' => $this->refresh_token,
            'grant_type'    => 'refresh_token',
            'client_id'     => $this->client_id,
        ), $this->token_endpoint );
        $request = array(
            'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        ),
        );
        $response = wp_remote_post( esc_url_raw( $endpoint ), $request );
        $response_code = (int) wp_remote_retrieve_response_code( $response );
        $response_body = wp_remote_retrieve_body( $response );
        $response_body = json_decode( $response_body, true );
        
        if ( isset( $response_body['access_token'] ) ) {
            $this->access_token = $response_body['access_token'];
        } else {
            $this->access_token = null;
        }
        
        if ( isset( $response_body['refresh_token'] ) ) {
            $this->refresh_token = $response_body['refresh_token'];
        }
        $this->save_data();
        return $response;
    }
    
    public function get_aweber_lists()
    {
        $account_id = ( isset( $_POST['accountId'] ) ? $_POST['accountId'] : '' );
        if ( !$account_id ) {
            wp_send_json_error();
        }
        $endpoint = "https://api.aweber.com/1.0/accounts/{$account_id}/lists";
        $request = array(
            'method'  => 'GET',
            'headers' => array(
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ),
        );
        $all_lists = array();
        do {
            $response = $this->remote_request( $endpoint, $request );
            if ( 400 <= (int) wp_remote_retrieve_response_code( $response ) ) {
                wp_send_json_error();
            }
            $response_body = wp_remote_retrieve_body( $response );
            if ( empty($response_body) ) {
                wp_send_json_error();
            }
            $response_body = json_decode( $response_body, true );
            
            if ( !empty($response_body['entries']) ) {
                $lists = wp_list_pluck( $response_body['entries'], 'name', 'id' );
                $all_lists = $all_lists + $lists;
            }
            
            
            if ( isset( $response_body['next_collection_link'] ) ) {
                $endpoint = $response_body['next_collection_link'];
            } else {
                $endpoint = '';
            }
        
        } while ($endpoint);
        
        if ( $all_lists ) {
            wp_send_json_success( $all_lists );
        } else {
            wp_send_json_error();
        }
    
    }

}
$aweber = ADFOIN_Aweber::get_instance();
/*
 * Saves connection mapping
 */
function adfoin_aweber_save_integration()
{
    $params = array();
    parse_str( adfoin_sanitize_text_or_array_field( $_POST['formData'] ), $params );
    $trigger_data = ( isset( $_POST["triggerData"] ) ? adfoin_sanitize_text_or_array_field( $_POST["triggerData"] ) : array() );
    $action_data = ( isset( $_POST["actionData"] ) ? adfoin_sanitize_text_or_array_field( $_POST["actionData"] ) : array() );
    $field_data = ( isset( $_POST["fieldData"] ) ? adfoin_sanitize_text_or_array_field( $_POST["fieldData"] ) : array() );
    $integration_title = ( isset( $trigger_data["integrationTitle"] ) ? $trigger_data["integrationTitle"] : "" );
    $form_provider_id = ( isset( $trigger_data["formProviderId"] ) ? $trigger_data["formProviderId"] : "" );
    $form_id = ( isset( $trigger_data["formId"] ) ? $trigger_data["formId"] : "" );
    $form_name = ( isset( $trigger_data["formName"] ) ? $trigger_data["formName"] : "" );
    $action_provider = ( isset( $action_data["actionProviderId"] ) ? $action_data["actionProviderId"] : "" );
    $task = ( isset( $action_data["task"] ) ? $action_data["task"] : "" );
    $type = ( isset( $params["type"] ) ? $params["type"] : "" );
    $all_data = array(
        'trigger_data' => $trigger_data,
        'action_data'  => $action_data,
        'field_data'   => $field_data,
    );
    global  $wpdb ;
    $integration_table = $wpdb->prefix . 'adfoin_integration';
    if ( $type == 'new_integration' ) {
        $result = $wpdb->insert( $integration_table, array(
            'title'           => $integration_title,
            'form_provider'   => $form_provider_id,
            'form_id'         => $form_id,
            'form_name'       => $form_name,
            'action_provider' => $action_provider,
            'task'            => $task,
            'data'            => json_encode( $all_data, true ),
            'status'          => 1,
        ) );
    }
    
    if ( $type == 'update_integration' ) {
        $id = esc_sql( trim( $params['edit_id'] ) );
        if ( $type != 'update_integration' && !empty($id) ) {
            return;
        }
        $result = $wpdb->update( $integration_table, array(
            'title'         => $integration_title,
            'form_provider' => $form_provider_id,
            'form_id'       => $form_id,
            'form_name'     => $form_name,
            'data'          => json_encode( $all_data, true ),
        ), array(
            'id' => $id,
        ) );
    }
    
    
    if ( $result ) {
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }

}

/*
 * Handles sending data to Aweber API
 */
function adfoin_aweber_send_data( $record, $posted_data )
{
    $record_data = json_decode( $record["data"], true );
    $data = $record_data["field_data"];
    if ( array_key_exists( "cl", $record_data["action_data"] ) ) {
        if ( $record_data["action_data"]["cl"]["active"] == "yes" ) {
            if ( !adfoin_match_conditional_logic( $record_data["action_data"]["cl"], $posted_data ) ) {
                return;
            }
        }
    }
    $account_id = $data["accountId"];
    $list_id = $data["listId"];
    $task = $record["task"];
    
    if ( $task == "subscribe" ) {
        $email = ( empty($data["email"]) ? "" : adfoin_get_parsed_values( $data["email"], $posted_data ) );
        $first_name = ( empty($data["firstName"]) ? "" : adfoin_get_parsed_values( $data["firstName"], $posted_data ) );
        $last_name = ( empty($data["lastName"]) ? "" : adfoin_get_parsed_values( $data["lastName"], $posted_data ) );
        $properties = array(
            "email" => $email,
            "name"  => $first_name . " " . $last_name,
        );
        $aweber = ADFOIN_Aweber::get_instance();
        $return = $aweber->create_contact(
            $properties,
            $account_id,
            $list_id,
            $record
        );
    }
    
    return;
}
