<?php
/**
 * Plugin Name: Woocommerce Klaviyo Add To List
 * Plugin URI:
 * Description: Integration with Klavityo service
 * Version: 1.0.0
 * Author: Viktor Starchenko viktor.s@overdose.digital
 * Author URI: https://roundkick.studio
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * License: GPLv2 or later

 */

include_once 'woocommerce-klaviyo-api.php';

if (!defined('ABSPATH')) exit;

    class WoocommerceKlaviyoAddToList {
//        method
        public function __construct(){

        }

        public function register(){

            //register post type
            add_action('init', array($this, 'wckl_custom_post_type'));

            // Add to list whent odrder status was changed
            add_action( 'woocommerce_order_status_changed', array($this,'wckl_trigger_request'), 99, 3 );

            //Add to list when new order was created
            add_action('woocommerce_thankyou', array($this, 'wckl_send_request_new_order'), 10, 1);

            // enqueue admin
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin'));

            //Add custom meta boxes to integration post type
            add_action( 'add_meta_boxes_wckl_intergation', array($this, 'wckl_intergation_metaboxes') );

            //Save custom meta boxes to integration post type
            add_action( 'save_post_wckl_intergation', array($this, 'wckl_intergation_save_post') );

            //Add menu admin
            add_action('admin_menu', array($this, 'wckl_add_admin_menu'));

            //Add link to plugin page
            add_filter('plugin_action_links_'.plugin_basename(__FILE__), array($this, 'wckl_add_plugin_setting_link'));

            //Init settings
            add_action('admin_init', array($this, 'wckl_settings_init'));

        }


        public function wckl_custom_post_type() {
            register_post_type('wckl_intergation', array(
                'public' => true,
                'labels' => array(
                    'name' => __( 'WCKL integrations' ),
                    'singular_name' => __( 'WCKL integration' )
                ),
                'public' => true,
                'supports'  => array( 'title', 'author'),
            ));
        }

        static function activation() {
            //update rewrite rules
            flush_rewrite_rules();
        }

        static function deactivation() {
            //update rewrite rules
            flush_rewrite_rules();
        }

        public function enqueue_admin() {
            wp_enqueue_style('wcklStyle', plugins_url('/assets/admin/css/style.css', __FILE__));
            wp_enqueue_script('wcklScript', plugins_url('/assets/admin/js/script.js', __FILE__));
        }

        /**
         *
         * Woccommerce Klaviyo Plugin Settings Page
         *
         */
        public function wckl_add_admin_menu() {
            add_menu_page(
                esc_html__( 'WC-Klaviyo integration (Add to list)', 'wckl' ),
                esc_html__('WC-Klaviyo integration (Add to list)'),
                'manage_options',
                'wc_kl_integration',
                array($this, 'wckl_admin_page'),
                'dashicons-wordpress-alt',
                6
            );
        }

        public function wckl_admin_page() {
            require_once plugin_dir_path(__FILE__).'admin/admin.php';
        }

        public function wckl_add_plugin_setting_link($links){
            $custom_link = '<a href="'. admin_url('admin.php?page=wc_kl_integration') .'">'. esc_html__('Settings', 'wckl') .'</a>';
            array_push($links, $custom_link);
            return $links;
        }

        public  function wckl_settings_init() {
            register_setting('wckl_settings', 'wckl_settings_options');

            add_settings_section('wckl_settings_section', esc_html__('Settings', 'wckl'), array($this, 'wckl_setting_section_html'), 'wc_kl_integration');

            add_settings_field( 'klaviyo_private_key', esc_html__('Klaviyo Private Key', 'wckl'), array($this, 'wckl_klaviyo_private_key_html'), 'wc_kl_integration', 'wckl_settings_section' );

            add_settings_field( 'clear_database', esc_html__('Clear database when deleting plugin', 'wckl'), array($this, 'wckl_clear_database_html'), 'wc_kl_integration', 'wckl_settings_section' );
        }

        public function wckl_setting_section_html() {
            echo esc_html__('', 'wckl');
        }


        public function wckl_klaviyo_private_key_html() {
            $options = get_option('wckl_settings_options');
            ?>
            <textarea type="text" name="wckl_settings_options[klaviyo_private_key]" value="<?php echo isset($options['klaviyo_private_key']) ? $options['klaviyo_private_key'] : '';?>"><?php echo isset($options['klaviyo_private_key']) ? $options['klaviyo_private_key'] : '';?> </textarea>
        <?php }

        public function wckl_clear_database_html() {
            $options = get_option('wckl_settings_options');
            ?>
            <input type="checkbox" name="wckl_settings_options[clear_database]" value="clear_db" <?php echo ($options['clear_database']) == 'clear_db' ? 'checked' : '';?>/>
        <?php }


        /**
         *
         * Woccommerce Klaviyo Integration page metaboxes
         *
         */
        public function wckl_intergation_metaboxes( ) {
            global $wp_meta_boxes;
            add_meta_box('postfunctiondiv', __('Function'), array($this, 'wckl_intergation_metaboxes_html'), 'wckl_intergation', 'normal', 'high');
        }


        /**
         *
         * Woccommerce Klaviyo get private key
         */
        public function get_klaviyo_private_key() {

            $options = get_option('wckl_settings_options');
            $klaviyoPrivateKey = $options['klaviyo_private_key'];
            $klaviyoPrivateKey = trim($klaviyoPrivateKey);
            return $klaviyoPrivateKey;

        }


        /**
         *
         * Woccommerce Klaviyo get lists ids
         *
         */
        public function get_klaviyo_list_id() {
            global $post;
            $custom = get_post_custom($post->ID);

            //Klaviyo private key
            $klaviyo_list_id = isset($custom["klaviyo_list_id"][0])?$custom["klaviyo_list_id"][0]:'';

            return $klaviyo_list_id;
        }


        /**
         *
         * Woccommerce Klaviyo generating integration posts metaboxes
         *
         */
        public function wckl_intergation_metaboxes_html() {
            global $post;
            $custom = get_post_custom($post->ID);


            //Action trigger
            $klaviyo_action_trigger = isset($custom["klaviyo_action_trigger"][0])?$custom["klaviyo_action_trigger"][0]:'';
            ?>
            <p>
                <label>Action trigger: </label>


                <select name="klaviyo_action_trigger" id="klaviyo_action_trigger" required="required">
                    <option value="new_order_created" <?php  echo ($klaviyo_action_trigger == 'new_order_created' ?  'selected':''); ?> > New order created  </option>
                    <option value="processing" <?php  echo ($klaviyo_action_trigger == 'processing' ?  'selected':''); ?> > Order Status Processing  </option>
                    <option value="on-hold" <?php  echo ($klaviyo_action_trigger == 'on-hold' ?  'selected':''); ?> > Order Status On-Hold  </option>
                    <option value="completed" <?php  echo ($klaviyo_action_trigger == 'completed' ?  'selected':''); ?> > Order Status Completed  </option>
                    <option value="failed" <?php  echo ($klaviyo_action_trigger == 'failed' ?  'selected':''); ?> > Order Status Failed  </option>
                    <option value="pending" <?php  echo ($klaviyo_action_trigger == 'pending' ?  'selected':''); ?> > Order Status Pending  </option>
                    <option value="refunded" <?php  echo ($klaviyo_action_trigger == 'refunded' ?  'selected':''); ?> > Order Status Refunded  </option>
                    <option value="cancelled" <?php  echo ($klaviyo_action_trigger == 'cancelled' ?  'selected':''); ?> > Order Status Cancelled  </option>
                </select>
            </p>

            <?php
            //List action
            $klaviyo_list_action = isset($custom["klaviyo_list_action"][0])?$custom["klaviyo_list_action"][0]:'';
            ?>
            <p>
                <label>List action: </label>
                <select name="klaviyo_list_action" id="klaviyo_list_action"  required="required">

                    <option value="add_to_list" <?php  echo ($klaviyo_list_action == 'add_to_list' ?  'selected':''); ?> >Add Members to a List</option>
                    <option value="subsribe_to_list" <?php  echo ($klaviyo_list_action == 'subsribe_to_list' ?  'selected':''); ?> >Subscribe Profiles to List</option>
                </select>
            <ol id="explanatoryText">
                <li>Adds profiles to a list will immediately add profiles to the list. If you would like to subscribe profiles to a list and use the double opt-in settings for the list, please use the subscribe endpoint.</li>
                <li>Subscribes profiles to a list. Profiles will be single or double opted into the specified list in accordance with that list’s settings. Note: If you have double opt-in turned on, users will not be added to list until they opt-in.</li>
            </ol>
            </p>



            <?php

            //Klaviyo list
            $woocommerceKlaviyoApi = new WoocommerceKlaviyoApi();
            $lists = $woocommerceKlaviyoApi->wckl_get_lists();
            $klaviyo_list_id = isset($custom["klaviyo_list_id"][0])?$custom["klaviyo_list_id"][0]:'';
            ?>
            <label>Select Klaviyo list: </label>
            <select name="klaviyo_list_id" id="klaviyo_list_id" required>
                <?php
                foreach($lists as $list) { ?>
                    <option value="<?php echo $list->list_id ?>" <?php  echo ($list->list_id == $klaviyo_list_id ?  'selected':''); ?>><?php echo $list->list_name ?></option>
                    <?php
                }
                ?>
            </select>
       <?php }


        /**
         *
         * Woccommerce Klaviyo save integration posts metaboxes
         *
         */
        public function wckl_intergation_save_post() {
            if(empty($_POST)) return;
            global $post;
            update_post_meta($post->ID, "klaviyo_list_id", $_POST["klaviyo_list_id"]);
            update_post_meta($post->ID, "klaviyo_list_action", $_POST["klaviyo_list_action"]);
            update_post_meta($post->ID, "klaviyo_action_trigger", $_POST["klaviyo_action_trigger"]);
        }


        /**
         *
         * Woccommerce Klaviyo trigger request when order status was changed
         *
         */
        public function wckl_trigger_request( $order_id, $old_status, $new_status ){
            $this->wckl_send_request_by_trigger($order_id, $new_status);
        }


        /**
         *
         * Woccommerce Klaviyo prepare request when new order was created
         *
         */
        public function wckl_send_request_by_trigger($order_id, $action_trigger) {
            $woocommerceKlaviyoApi = new WoocommerceKlaviyoApi();
            $wckl_integrations = $woocommerceKlaviyoApi->wckl_get_integrations_by_trigger($action_trigger);

            foreach ($wckl_integrations as $item) {

                $klaviyo_list_action = get_post_custom_values( 'klaviyo_list_action', $item['post_id'] )[0];

                if( $klaviyo_list_action == 'subsribe_to_list' ) {
                    $woocommerceKlaviyoApi->wckl_subscribe_to_list($order_id, $item['post_id']);
                } else if ( $klaviyo_list_action == 'add_to_list' ) {
                    $woocommerceKlaviyoApi->wckl_add_to_list($order_id, $item['post_id']);
                }

            }

        }


        /**
         *
         * Woccommerce Klaviyo trigger request when new order was created
         *
         */
        public function wckl_send_request_new_order($order_id) {
            $woocommerceKlaviyoApi = new WoocommerceKlaviyoApi();
            $wckl_integrations = $woocommerceKlaviyoApi->wckl_get_integrations_by_trigger('new_order_created');

            foreach ($wckl_integrations as $item) {

                $klaviyo_list_action = get_post_custom_values( 'klaviyo_list_action', $item['post_id'] )[0];
                $klaviyo_action_trigger = get_post_custom_values( 'klaviyo_action_trigger', $item['post_id'] )[0];

                if( $klaviyo_list_action == 'subsribe_to_list' ) {
                    $woocommerceKlaviyoApi->wckl_subscribe_to_list($order_id, $item['post_id']);
                } else if ( $klaviyo_list_action == 'add_to_list' ) {
                    $woocommerceKlaviyoApi->wckl_add_to_list($order_id, $item['post_id']);
                }

            }

        }





    }

    if(class_exists('WoocommerceKlaviyoAddToList')) {
        $woocommerceKlaviyoAddToList =  new WoocommerceKlaviyoAddToList();
        $woocommerceKlaviyoAddToList->register();
    }

    register_activation_hook( __FILE__, array( $woocommerceKlaviyoAddToList, 'activation' ) );
    register_activation_hook( __FILE__, array( $woocommerceKlaviyoAddToList, 'deactivation' ) );


















