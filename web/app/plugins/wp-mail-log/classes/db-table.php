<?php

namespace WML\Classes;

class DbTable
{


    public static function wml_plugin_activated()
    {
        $wml_db_version = "0.3";
        if (get_option('wml_db_version') !== $wml_db_version) {
            self::create_db_table();
        }
        // self::create_db_table();
    }

    /**
     * Create database table when the Plugin is installed for the first time
     * @global object $wpdb
     * @global string $table_name
     */

    public static function create_db_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wml_entries';

        $wpdb_collate = $wpdb->collate;


        $sql = "CREATE TABLE {$table_name} (
            `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            `to_email` VARCHAR(100) NOT NULL,
            `subject` VARCHAR(250) NOT NULL,
            `message` TEXT NOT NULL,
            `headers` TEXT NOT NULL,
            `attachments` TEXT NOT NULL,
            `sent_date` VARCHAR(50) NOT NULL,
            `captured_gmt` VARCHAR(50) NOT NULL
            ) collate {$wpdb_collate};";
        //echo $sql;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql, true);

        if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}wml_entries'") != '') {
            update_option('wml_db_version', WML_VERSION);
        }
    }
}
