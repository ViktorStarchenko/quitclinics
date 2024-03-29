<?php
/*This file is part of quitclinics-child, quitclinics child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

if (!function_exists('dd')) {
    function dd($data)
    {
        ini_set("highlight.comment", "#969896; font-style: italic");
        ini_set("highlight.default", "#FFFFFF");
        ini_set("highlight.html", "#D16568");
        ini_set("highlight.keyword", "#7FA3BC; font-weight: bold");
        ini_set("highlight.string", "#F2C47E");
        $output = highlight_string("<?php\n\n" . var_export($data, true), true);
        echo "<div style=\"background-color: #1C1E21; padding: 1rem\">{$output}</div>";
        die();
    }
}

if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {
	function quitclinics_child_enqueue_child_styles() {
	    // loading parent style
	    wp_register_style(
	      'parente2-style',
	      get_template_directory_uri() . '/style.css'
	    );

	    wp_enqueue_style( 'parente2-style' );
	    // loading child style
	    wp_register_style(
	      'childe2-style',
	      get_stylesheet_directory_uri() . '/style.css'
	    );
	    wp_enqueue_style( 'childe2-style');



//        ADD CUSTOM STYLES AND SCRIPTS
//        bootstrap styles
//        wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ));

//        main custom styles
        wp_enqueue_style( 'country-select', get_theme_file_uri( '/assets/js/country-select/build/css/countrySelect.min.css' ), array(), false, 'all');
//        wp_enqueue_style( 'qc-style-heydoc', get_theme_file_uri( '/assets/css/style-h.css' ), array(), false, 'all');

        wp_enqueue_style( 'slick-styles', get_theme_file_uri( '/assets/css/slick.css' ), array(), false, 'all');
        wp_enqueue_style( 'qc-style', get_theme_file_uri( '/assets/css/qc-style.css' ), array(), false, 'all');
        //bootstrap scripts
//        wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array(), '1', true );

        //main custom scripts
        if (!is_checkout() && !is_cart()) {
            wp_enqueue_script( 'jq-351', get_theme_file_uri( '/assets/js/jquery-3.5.1.min.js' ), array(), '1', true );
            wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array('jq-351'), '1', true );
        }
        wp_enqueue_script( 'country-select', get_theme_file_uri( '/assets/js/country-select/build/js/countrySelect.min.js' ), array(), '1', true );
        wp_enqueue_script( 'dobpicker', get_theme_file_uri( '/assets/js/dobpicker.js' ), array(), '1', true );



            wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array(), '1', true );

//        wp_enqueue_script( 'heydoc', get_theme_file_uri( '/assets/js/heydoc-script.js' ), array(), '1', true );
        wp_enqueue_script( 'main', get_theme_file_uri( '/assets/js/main.js' ), array(), '1', true );

	 }
}
add_action( 'wp_enqueue_scripts', 'quitclinics_child_enqueue_child_styles' );

/*Write here your own functions */

function custom_left_menu() {
  register_nav_menu('new-left-menu',__( 'Left menu' ));
}
add_action( 'init', 'custom_left_menu' );


//ADVANCED CUSTOM FIELDS
include 'inc/acf.php';
include 'inc/header-lib.php';
include 'inc/woocommerce-lib.php';
include 'inc/heydoc.php';
include 'inc/cloudcheck-global-verification.php';
include 'inc/seo.php';
include 'inc/notice_pregnant_email_template.php';
include 'inc/medical-history-funcs.php';
include 'inc/user-medical-profile-fields.php';
include 'inc/heydoc-renewal.php';

include 'inc/custom-wc-bulk.php';

if (get_field('klaviyo_settings', 'option')['adjust_renewal_date']) {
    include 'inc/qc-wcs-set-correct-newal-date.php';
}
if (get_field('klaviyo_settings', 'option')['update_klaviyo_profile']) {
    include 'inc/qc-wc-klaviyo-update-profile.php';
}


function get_excerpt($limit){
    $excerpt = get_the_content();
    $excerpt = preg_replace(" ([.*?])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt;
    return $excerpt;
}


add_theme_support( 'align-wide' );


/*** Custom excerpt ***/
function get_custom_excerpt($content, $limit, $ellipsis = true){

    $excerpt = $content;
    $excerpt = preg_replace(" ([.*?])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    $excerpt = $excerpt;
    if ($ellipsis == true) {
        $excerpt.= '...';
    }

    return $excerpt;
}


//// login
//$login_data                  = array();
//$login_data['user_login']    = 'redirect20@test.com';
//$login_data['user_password'] = '1st5thmar';
//$login_data['remember']      = false;
//$user_verify                 = wp_signon($login_data, false);

//if (!is_wp_error($user_verify)) {
//    $login_status = array(
//        'login_status' => 'OK'
//    );
//    wp_send_json($login_status);
//    wp_set_current_user($user_verify->ID);
//}

add_filter( 'send_password_change_email', '__return_false' );
add_filter( 'send_email_change_email', '__return_false');

add_action('phpmailer_init', 'wse199274_intercept_registration_email');
function wse199274_intercept_registration_email($phpmailer){
    $admin_email = get_option( 'admin_email' );

    # Intercept username and password email by checking subject line
    if( strpos($phpmailer->Subject, 'Your username and password info') ){
        # clear the recipient list
        $phpmailer->ClearAllRecipients();
        # optionally, send the email to the WordPress admin email
        $phpmailer->AddAddress($admin_email);
    }else{
        #not intercepted
    }
}



//add_filter( 'woocommerce_min_password_strength', 'reduce_min_strength_password_requirement' );
//function reduce_min_strength_password_requirement( $strength ) {
//    // 3 => Strong (default) | 2 => Medium | 1 => Weak | 0 => Very Weak (anything).
//    return 2;
//}

/**
 * Change the strength requirement on the woocommerce password
 *
 * Strength Settings
 * 4 = Strong
 * 3 = Medium (default)
 * 2 = Also Weak but a little stronger
 * 1 = Password should be at least Weak
 * 0 = Very Weak / Anything
 */
add_filter( 'woocommerce_min_password_strength', 'misha_change_password_strength' );

function misha_change_password_strength( $strength ) {
    return 1;
}


add_filter( 'wcs_allow_synced_product_early_renewal', '__return_true', 10 );


add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

function add_async_attribute($tag, $handle)
{
    if(!is_admin()){
        if ('jquery-core' == $handle) {
            return $tag;
        }
        return str_replace(' src', ' defer src', $tag);
    }else{
        return $tag;
    }

}

function script_comment_reply(){
    wp_deregister_script( 'comment-reply');
}
add_action('init','script_comment_reply');


//add_action( 'woocommerce_email', 'unhook_those_pesky_emails' );
//
//function unhook_those_pesky_emails( $email_class ) { remove_action( 'woocommerce_order_status_completed_notification', array( $email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger' ) ); }

/**
 * Function for Self referencing Canonicals
 * @param $canonical
 * @return string
 */
function modify_yoast_canonical_tag( $canonical ) {
    // Get the current pagination page number
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // Replacing the value of the canonical tag with our own
    if ( $paged > 1 ) {
        // Forming a new URL with the pagination page number
        $new_canonical = trailingslashit( $canonical ) . 'page/' . $paged;

        // Returning the new value of the canonical tag
        return $new_canonical;
    }

    // If not a pagination page, return the original value of the canonical tag
    return $canonical;
}
add_filter( 'wpseo_canonical', 'modify_yoast_canonical_tag' );
