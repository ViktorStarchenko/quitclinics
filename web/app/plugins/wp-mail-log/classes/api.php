<?php

namespace WML\Classes;


use WP_REST_Controller;
use WP_REST_Server;
use WP_Query;
use WP_REST_Request;
use WP_Error;
use WP_REST_Response;

class API extends WP_REST_Controller
{

    protected $namespace = 'wml/v1';
    /**
     * Constructor.
     */
    public function __construct()
    {
    }

    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/wml_logs',
            // Get Log -> done
            [
                [
                    'methods'             => WP_REST_Server::CREATABLE,
                    'callback'            => [$this, 'view_log'],
                    'permission_callback' => [$this, 'check_permission'],
                ],
                // Delete Log -> done
                [
                    'methods'             => WP_REST_Server::DELETABLE,
                    'callback'            => [$this, 'delete_log'],
                    'permission_callback' => [$this, 'check_permission'],
                ],
            ]
        );
    }

    private function get_params($request)
    {
        return $request->get_json_params();
    }
    private function make_params()
    {
    }

    public function view_log(WP_REST_Request $request)
    {

        global $wpdb;
        $params = $this->get_params($request);
        //print_r($params);
        $table_name  = $wpdb->prefix . 'wml_entries';

        $query_cols = ["id", "to_email", "subject", "message", "headers", "attachments",  "DATE_FORMAT(sent_date, '%Y/%m/%d %H:%i:%S') as sent_date"];
        $entry_query = "SELECT distinct " . implode(",", $query_cols) . " FROM " . $table_name;
        $where[] = "1 = 1";

        if (empty($params['startDate'])) {
            $params['startDate'] =  date('Y-m-d H:i:s', strtotime('-30 days'));
        }
        if (empty($params['endDate'])) {
            $params['endDate'] =  date('Y-m-d H:i:s');
        }
        if ($params['startDate'] !== '' && $params['startDate'] !== null) {

            //$params['startDate'] = str_replace('/', '-', $params['startDate']);
            // $date = date_create($params['startDate']);
            // $params['startDate'] = date_format($date, "Y-m-d");
            $where[] = " DATE_FORMAT(sent_date,GET_FORMAT(DATE,'JIS')) >= '" . $params['startDate'] . "'";
        }
        if ($params['endDate'] !== '' && $params['endDate'] !== null) {
            // $date = date_create($params['endDate']);
            // $params['endDate'] = date_format($date, "Y-m-d");
            if ($params['startDate'] !== '') {
                $where[] = " DATE_FORMAT(sent_date,GET_FORMAT(DATE,'JIS')) <= '" . $params['endDate'] . "'";
            } else {
                $where[] = "DATE_FORMAT(sent_date,GET_FORMAT(DATE,'JIS')) <= '" . $params['endDate'] . "'";
            }
        }


        // Order By
        $orderby = " order by id desc";

        if ($params['pageIndex'] >= 1) {
            $limit = ' limit ' . $params['pageSize'] * $params['pageIndex'] . ',' . $params['pageSize'];
        } else {
            $limit = ' limit ' . $params['pageSize'];
        }
        $entry_query .= " WHERE " . implode(' and ', $where) . $orderby . $limit;
        // return $entry_query;
        $sql = $wpdb->get_results($entry_query);

        $cols = [];
        foreach ($wpdb->get_col("DESC " . $table_name, 0) as $column_name) {
            $cols[] = $column_name;
        }
        $entry_count_query = "SELECT count(id) from " . $table_name . " WHERE " . implode(' and ', $where);
        //return $entry_count_query;
        $entry_result = $wpdb->get_var($entry_count_query);
        $rowcount = $wpdb->num_rows;
        $columns = ["id", "to_email", "subject", "message", "headers",  "sent_date"];

        foreach ($sql as $key => $row) {
            $formatedTag =   wp_kses($row->message, $this->wml_kses_allowed_html('post'));
            $row->message = $formatedTag;
            // $row->message = "<pre>" . $row->message . "</pre>";
        }
        $res = [
            // 'columns'   => $cols,
            'columns' => $columns,
            'data' => $sql,
            'totalRows' => $entry_result,
            'rowCount'  =>  $rowcount,
        ];

        return rest_ensure_response($res);
    }

    public function delete_log(WP_REST_Request $request)
    {

        global $wpdb;
        $ids = $this->get_params($request);
        $message = [];

        $table_name  = $wpdb->prefix . 'wml_entries';
        $deleteRow = "Delete from {$table_name} where id IN (" . implode(",", $ids) . ")";
        $dl1 = $wpdb->query($deleteRow);
        if ($dl1 == 0) {
            $message['status'] = "failed";
            $message['message'] = "Could not able to delete Entries";
        } else {
            $message['status'] = "passed";
            $message['message'] = "Entries Deleted";
        }
        return rest_ensure_response($message);
    }
    protected function wml_kses_allowed_html($context = 'post')
    {

        $allowed_tags = wp_kses_allowed_html($context);

        $allowed_tags['link'] = array(
            'rel'   => true,
            'href'  => true,
            'type'  => true,
            'media' => true,
        );

        return $allowed_tags;
    }

    // global $wpdb;
    // $table_name = $wpdb->prefix . 'wml_entries';
    // $sql = "(SELECT * FROM" . $table_name . ")";
    // require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    // $logs = ;
    // return wp_send_json($sql);
    //return rest_ensure_response('This is private data.');


    public function check_permission()
    {
        // Restrict endpoint to only users who have the edit_posts capability.
        if (!current_user_can('edit_posts')) {
            return new WP_Error('rest_forbidden', esc_html__('OMG you can not view private data.', 'my-text-domain'), array('status' => 401));
        }

        // This is a black-listing approach. You could alternatively do this via white-listing, by returning false here and changing the permissions check.
        return true;
    }
}
