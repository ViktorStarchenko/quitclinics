<?php



if (!defined("WP_UNINSTALL_PLUGIN")){
    die;
}

//Delete post type from DB

//global $wpdb;
//$wpdb->query("DELETE FROM {$wpdb->posts} WHERE post_type IN ('Integration');");


//remove meta


//remove tax/terms


$options = get_option('wckl_settings_options');
if ( $options['clear_database'] == 'clear_db' ) {
    $integrations = get_posts(array('post_type' => 'wckl_intergation', 'numberposts'=> -1));

    foreach($integrations as $integration) {
        wp_delete_post($integration->ID, true);
    }
}
