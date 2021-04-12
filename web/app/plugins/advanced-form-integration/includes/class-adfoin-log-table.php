<?php
if( !class_exists( 'WP_List_Table' ) ) require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

// Connection List Table class.
class Advanced_Form_Integration_Log_Table extends WP_List_Table {

    /**
     * Construct function
     * Set default settings.
     */
    function __construct() {
        global $status, $page;
        //Set parent defaults
        parent::__construct( array(
            'ajax'     => FALSE,
            'singular' => 'log',
            'plural'   => 'logs',
        ) );
    }

    /**
     * Renders the columns.
     *
     * @since 1.0.0
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'id':
                $value = $item['id'];
                break;
            case 'response_code':
                $value = $item['response_code'];
                break;
            case 'response_message':
                $value = $item['response_message'];
                break;
            case 'integration_id':
                $value = $item['integration_id'];
                break;
            case 'request_data':
                $value = $item['request_data'];
                break;
            case 'response_data':
                $value = $item['response_data'];
                break;
            case 'time':
                $value = $item['time'];
                break;
            case 'action':
                $value = $item['action'];
                break;
            default:
                $value = '';
        }

        return apply_filters( 'adfoin_log_table_column_value', $value, $item, $column_name );
    }

    /**
     * Retrieve the table columns.
     *
     * @since 1.0.0
     * @return array $columns Array of all the list table columns.
     */
    function get_columns() {
        $columns = array(
            'cb'               => '<input type="checkbox" />',
            'response_code'    => esc_html__( 'Response Code', 'advanced-form-integration' ),
            'response_message' => esc_html__( 'Response Message', 'advanced-form-integration' ),
            'integration_id'   => esc_html__( 'Integration ID', 'advanced-form-integration' ),
            'request_data'     => esc_html__( 'Request Data', 'advanced-form-integration' ),
            'response_data'    => esc_html__( 'Response Data', 'advanced-form-integration' ),
            'time'             => esc_html__( 'Time', 'advanced-form-integration' )
        );

        return apply_filters( 'adfoin_log_table_columns', $columns );
    }

    /**
     * Render the checkbox column.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function column_cb( $item ) {
        return '<input type="checkbox" name="log_id[]" value="' . absint( $item['id'] ) . '" />';
    }

    /**
     * Render the form name column with action links.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function column_response_code( $item ) {

        $name = ! empty( $item['response_code'] ) ? $item['response_code'] : _e( 'Unknown', 'advanced-form-integration' );
        $name = sprintf( '<span><strong>%s</strong></span>', esc_html__( $name ) );

        // Build all of the row action links.
        $row_actions = array();

        // Edit.
        $row_actions['view'] = sprintf(
            '<a href="%s" title="%s">%s</a>',
            add_query_arg(
                array(
                    'action' => 'view',
                    'id'     => $item['id'],
                ),
                admin_url( 'admin.php?page=advanced-form-integration-log' )
            ),
            esc_html__( 'View', 'advanced-form-integration' ),
            esc_html__( 'View', 'advanced-form-integration' )
        );

        // Build the row action links and return the value.
        return $name . $this->row_actions( apply_filters( 'adfoin_integration_row_actions', $row_actions, $item ) );
    }

    public function column_request_data( $item ) {
        echo substr( $item["request_data"], 0, 100 ) . "...";
    }

    public function column_response_data( $item ) {
        echo substr( $item["response_data"], 0, 50 ) . "...";
    }

    /**
     * Define bulk actions available for our table listing.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_bulk_actions() {

        $actions = array(
            'delete' => esc_html__( 'Delete', 'advanced-form-integration' ),
        );

        return $actions;
    }

    /**
     * Process the bulk actions.
     *
     * @since 1.0.0
     */
    public function process_bulk_actions() {

        $ids = isset( $_REQUEST['log_id'] ) ? $_REQUEST['log_id'] : array();

        if ( ! is_array( $ids ) ) {
            $ids = array( $ids );
        }

        $ids    = array_map( 'absint', $ids );
        $action = ! empty( $_REQUEST['action'] ) ? $_REQUEST['action'] : false;

        if ( empty( $ids ) || empty( $action ) ) {
            return;
        }

        // Delete one or multiple relations - both delete links and bulk actions.
        if ( 'delete' === $this->current_action() ) {

            if (
                wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-logs' ) ||
                wp_verify_nonce( $_REQUEST['_wpnonce'], 'adfoin_delete_log_nonce' )
            ) {

                foreach ( $ids as $id ) {
                    $this->delete( $id );
                }

                advanced_form_integration_redirect( admin_url( 'admin.php?page=advanced-form-integration-log' ) );

                exit;
            }
        }
    }

    /**
     * Sortable settings.
     */
    function get_sortable_columns() {
        return array(
            'integration_id'           => array('integration_id', TRUE)
        );
    }

    public function fetch_table_data( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'number'    => 20,
            'offset'    => 0,
            'orderby'   => 'id',
            'order'     => 'DESC'
        );

        $args  = wp_parse_args( $args, $defaults );

        $log_table     = $wpdb->prefix . 'adfoin_log';
        $sql = "SELECT * FROM {$log_table}";

        if ( ! empty( $args['orderby'] ) ) {
            $sql .= ' ORDER BY ' . esc_sql( $args['orderby'] );
            $sql .= ! empty( $args['order'] ) ? ' ' . esc_sql( $args['order'] ) : ' ASC';
        }

        $sql .= " LIMIT {$args['number']}";

        $sql .= ' OFFSET ' . $args['offset'];

        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }

    //Query, filter data, handle sorting, pagination, and any other data-manipulation required prior to rendering
    public function prepare_items() {
        // Process bulk actions if found.
        $this->process_bulk_actions();

        $count                 = $this->count();
        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->admin_header();

        $current_page          = $this->get_pagenum();
        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;

        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && !empty( $_REQUEST['orderby'] ) ) {
            $args['orderby'] = sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) );
        }

        if ( isset( $_REQUEST['order'] ) && !empty( $_REQUEST['order'] ) ) {
            $args['order'] = sanitize_text_field( wp_unslash( $_REQUEST['order'] ) );
        }

        $this->items = $this->fetch_table_data( $args );


        $this->set_pagination_args(
            array(
                'total_items' => $count,
                'per_page'    => $per_page,
                'total_pages' => ceil( $count / $per_page ),
            )
        );
    }

    /*
     * Renders status column
     */
    public function column_status($item) {

        if ($item['status']) {
            $actions = "<span onclick='window.location=\"admin.php?page=advanced-form-integration-log&action=status&id=".$item['id']."\"'  class='span_activation_cheackbox'  ><a class='a_activation_cheackbox' href='?page=advanced-form-integration&action=edit&id=".$item['id']."'>  <input type='checkbox' name='status' checked=checked > </a></span>" ;
        }else{
            $actions = "<span onclick='window.location=\"admin.php?page=advanced-form-integration&action-log=status&id=".$item['id']." \"'  class='span_activation_cheackbox'  ><a class='a_activation_cheackbox' href='?page=advanced-form-integration&action=edit&id=".$item['id']."'>  <input type='checkbox' name='status' > </a></span>" ;
        }


        // print_r($item);

        return   $actions ;
    }

    /*
     * Handles delete
     */
    public function delete( $id='' ) {
        global $wpdb;
        $log_table      = $wpdb->prefix.'adfoin_log';
        $action_status  = $wpdb->delete( $log_table, array( 'id' => $id ) );

        return $action_status;
    }

    /*
     * Handles connection count
     */
    public function count() {
        global $wpdb;

        $log_table = $wpdb->prefix.'adfoin_log';
        $count     =  $wpdb->get_var("SELECT COUNT(*) FROM " . $log_table );

        return $count;
    }

    /*
     * Handles column width
     */
    public function admin_header() {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
        if( 'advanced-form-integration-log' != $page )
            return;

        echo '<style type="text/css">';
        echo '.wp-list-table .column-id { width: 10%; }';
        echo '.wp-list-table .column-response_code { width: 8%; }';
        echo '.wp-list-table .column-response_message { width: 8%; }';
        echo '.wp-list-table .column-integration_id { width: 8%; }';
        echo '.wp-list-table .column-request_data { width: 23%; }';
        echo '.wp-list-table .column-response_data { width: 23%; }';
        echo '.wp-list-table .column-time { width: 10%; }';
        echo '</style>';
    }
}