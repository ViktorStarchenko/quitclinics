<?php

/**
 * Class Admin_Menu
 *
 */
class Advanced_Form_Integration_Admin_Menu {
    /**
     * Class constructor.
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Register the admin menu.
     *
     * @return void
     */
    public function admin_menu() {
        global $submenu;

        $hook1 = add_menu_page( esc_html__( 'Advanced Form Integration', 'advanced-form-integration' ), esc_html__( 'AFI', 'advanced-form-integration' ), 'manage_options', 'advanced-form-integration', array( $this, 'adfoin_routing' ), 'data:image/svg+xml;base64,' . base64_encode( '<?xml version="1.0" encoding="UTF-8" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">  <image id="image0" width="20" height="20" x="0" y="0" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAANlBMVEUAAACfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpaqfpar////f8INVAAAAEHRSTlMAEFCAIECP72DPcK/fnzC//tkUDAAAAAFiS0dEEeK1PboAAAAHdElNRQfkBRcXIwYKjHTDAAAAiElEQVQY05XQSRLEIAgFUBxwtuH+p21M/CbbsNJXBfIl+ljOh+AdUWSOoKSrcqGgGrZV3dUe7HYdjTllncCf2bxOcbXcaAPHHs4HRTVhiwq0gwcmYFZlYHi1N2AH2hodKTKw6Omf53UalnANiF3HQX9FFNuiPjGp5Dt6dS+kmGwFsRFFpHz58j8aeAeztwD5dgAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAyMC0wNS0yM1QyMzozNTowNiswMzowMJ3oUI8AAAAldEVYdGRhdGU6bW9kaWZ5ADIwMjAtMDUtMjNUMjM6MzU6MDYrMDM6MDDstegzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAABJRU5ErkJggg==" /></svg>' ) );
        add_submenu_page( 'advanced-form-integration', esc_html__( 'Advanced Form Integration', 'advanced-form-integration' ), esc_html__( 'Integrations', 'advanced-form-integration' ), 'manage_options', 'advanced-form-integration', array( $this, 'adfoin_routing' ) );
        $hook2 = add_submenu_page( 'advanced-form-integration', esc_html__( 'Integrations', 'advanced-form-integration' ), esc_html__( 'Add New', 'advanced-form-integration' ), 'manage_options', 'advanced-form-integration-new', array( $this, 'adfoin_new_integration' ) );
        add_submenu_page( 'advanced-form-integration', esc_html__( 'Settings', 'advanced-form-integration' ), esc_html__( 'Settings', 'advanced-form-integration'), 'manage_options', 'advanced-form-integration-settings', array( $this,'adfoin_settings') );
        add_submenu_page( 'advanced-form-integration', esc_html__( 'Log', 'advanced-form-integration' ), esc_html__( 'Log', 'advanced-form-integration'), 'manage_options', 'advanced-form-integration-log', array( $this,'adfoin_log') );

        add_action( 'admin_head-' . $hook1, array( $this, 'enqueue_assets' ) );
        add_action( 'admin_head-' . $hook2, array( $this, 'enqueue_assets' ) );
    }

    public function enqueue_assets() {
        wp_enqueue_style( 'adfoin-main-style' );
        wp_enqueue_script( 'adfoin-vuejs' );
        do_action( 'adfoin_custom_script' );
        wp_enqueue_script( 'adfoin-main-script' );
    }

    /**
     * Display the Tasks page.
     *
     * @return void
     */
    public function adfoin_routing() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'edit':
                $this->adfoin_edit( $id );
                break;
            case 'status':
                $this->adfoin_change_status($id);
                break;
            default:
                $this->adfoin_list_page() ;
                break;
        }
    }

    /*
     * This function generates the list of connections
     */
    public function adfoin_list_page() {
        if ( isset( $_GET['status'] ) ) {
            $status = $_GET['status'];
        }

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">
                <?php _e( 'Integrations', 'advanced-form-integration' ); ?>
            </h1>
            <a href="<?php echo admin_url( 'admin.php?page=advanced-form-integration-new' ); ?>" class="page-title-action"><?php _e( 'Add New', 'advanced-form-integration' ); ?></a>

            <form id="form-list" method="post">
                <input type="hidden" name="page" value="advanced-form-integration"/>

                <?php
                $list_table = new Advanced_Form_Integration_List_Table();
                $list_table->prepare_items();
                $list_table->display();
                ?>
            </form>
        </div>
        <?php
    }

    /*
     * Handles new connection
     */
    public function adfoin_new_integration(){

        $form_providers   = adfoin_get_form_providers();
        $action_providers = adfoin_get_action_porviders();
        ksort( $action_providers );

        require_once ADVANCED_FORM_INTEGRATION_VIEWS . '/new_integration.php';
    }

    /*
     * Handles connection view
     */
    public function adfoin_view( $id='' ) {
    }

    /*
     * Handles connection edit
     */
    public function adfoin_edit( $id='' ) {

        if ( $id ) {
            require_once ADVANCED_FORM_INTEGRATION_VIEWS . '/edit_integration.php';
        }
    }

    /*
     * Settings Submenu View
     */
    public function adfoin_settings( $value = '' ) {
        $tabs = adfoin_get_settings_tabs();

        include ADVANCED_FORM_INTEGRATION_VIEWS . '/settings.php';
    }

    /*
     * Log Submenu View
     */
    public function adfoin_log( $value = '' ) {

        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'view':
                $this->adfoin_log_view( $id );
                break;
            default:
                $this->adfoin_log_list_page() ;
                break;
        }

    }

    /*
 * This function generates the list of connections
 */
    public function adfoin_log_list_page() {
        if ( isset( $_GET['status'] ) ) {
            $status = $_GET['status'];
        }

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">
                <?php _e( 'Log', 'advanced-form-integration' ); ?>
            </h1>

            <form id="form-list" method="post">
                <input type="hidden" name="page" value="advanced-form-integration-log"/>

                <?php
                $list_table = new Advanced_Form_Integration_Log_Table();
                $list_table->prepare_items();
                $list_table->display();
                ?>
            </form>
        </div>
        <?php
    }

    /*
     * Handles log view
     */
    public function adfoin_log_view( $id='' ) {

        if ( $id ) {
            require_once ADVANCED_FORM_INTEGRATION_VIEWS . '/view_log.php';
        }
    }

    /*
     * Relation Status Change adfoin_status
     */
    public function adfoin_change_status( $id = '' ) {
        echo $id;

        global $wpdb;

        $relation_table = $wpdb->prefix . "adfoin_integration";
        $status_data    = $wpdb->get_row( "SELECT * FROM {$relation_table} WHERE id = {$id}", ARRAY_A );
        $status         = $status_data["status"];

        if ( $status ) {
            $action_status = $wpdb->update( $relation_table,
                array(
                    'status' => false,
                ),
                array( 'id'=> $id )
            );
        }else{
            $action_status = $wpdb->update( $relation_table,
                array(
                    'status' => true ,
                ),
                array( 'id'=> $id )
            );
        }

        advanced_form_integration_redirect( admin_url( 'admin.php?page=advanced-form-integration' ) );
    }
}
