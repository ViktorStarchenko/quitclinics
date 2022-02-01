<?php
global $wpdb;

$table            = $wpdb->prefix . 'adfoin_log';
$result           = $wpdb->get_row( "SELECT * FROM " . $table . " WHERE id =" . $id, ARRAY_A );
$integration_id   = $result["integration_id"] ? $result["integration_id"] : "";
$request_data     = $result["request_data"] ? json_decode( $result["request_data"], true ) : "";
$response_code    = $result["response_code"] ? $result["response_code"] : "";
$response_data    = $result["response_data"] ? json_decode( $result["response_data"], true ) : "";
$response_message = $result["response_message"] ? $result["response_message"] : "";
$time             = $result["time"] ? $result["time"] : "";
?>

<div class="wrap">

    <div id="icon-options-general" class="icon32">  </div>
    <h1> <?php esc_attr_e( 'Log', 'advanced-form-integration' ); ?>
        <a href="<?php echo admin_url( 'admin.php?page=advanced-form-integration-log' ); ?>" class="page-title-action"><?php _e( 'Back', 'advanced-form-integration' ); ?></a>
    </h1>


    <div>

        <div id="post-body" class="metabox-holder ">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Time', 'advanced-form-integration' ); ?></th>
                    <td>
                        <p>
                            <?php echo esc_attr( $time ); ?>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Integration ID', 'advanced-form-integration' ); ?></th>
                    <td>
                        <p>
                            <?php echo esc_attr( $integration_id ); ?>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Request Data', 'advanced-form-integration' ); ?></th>
                    <td>
                        <div>
                            <pre id="request-data"></pre>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Response Code', 'advanced-form-integration' ); ?></th>
                    <td>
                        <p>
                            <?php echo stripslashes( $response_code ); ?>
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Response Data', 'advanced-form-integration' ); ?></th>
                    <td>
                        <div>
                            <pre id="response-data"></pre>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"> <?php _e( 'Response Message', 'advanced-form-integration' ); ?></th>
                    <td>
                        <p>
                            <?php echo stripslashes( $response_message ); ?>
                        </p>
                    </td>
                </tr>
            </table>

        </div>
        <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div>
    <!-- #poststuff -->

</div> <!-- .wrap -->

<script>
    var requestData  = <?php echo json_encode( $request_data, true ); ?>;
    var responseData = <?php echo json_encode( $response_data, true ); ?>;

    document.getElementById("request-data").textContent = JSON.stringify(requestData, undefined, 2);
    document.getElementById("response-data").textContent = JSON.stringify(responseData, undefined, 2);
</script>