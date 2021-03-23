<?php

namespace WML\Classes;

class Capture_Mail
{
    /**
     * Log all email to database
     *
     * @global object $wpdb
     * @param array $mail_info Information about email
     * @return array Information about email
     */
    static function log_email($mail_info)
    {
        // echo '<pre>';
        // print_r($mail_info);
        // echo "</pre>";

        global $wpdb;

        $table_name = $wpdb->prefix . 'wml_entries';
        $attachment_present = (count($mail_info['attachments']) > 0) ? "true" : "false";
        if (is_array($mail_info['to'])) {
            $mail_to = implode(", ", $mail_info['to']);
        } else {
            $mail_to = $mail_info['to'];
            $parts = explode(",", $mail_to);
            $mail_to = implode(', ', $parts);
        }
        // Log into the database
        $wpdb->insert($table_name, array(
            'to_email' => $mail_to,
            'subject' => $mail_info['subject'],
            'message' => $mail_info['message'],
            'headers' => $mail_info['headers'],
            'attachments' => $attachment_present,
            'sent_date' =>  current_time('mysql', $gmt = 0),
            'captured_gmt' =>  current_time('mysql', $gmt = 1),
        ));

        // return unmodifiyed array
        return $mail_info;
    }
}
