<?php

/**
 * Add New Tab on the My Account page
 */

// ------------------

// 1. Register new endpoint (URL) for My Account page

// Note: Re-save Permalinks or it will give 404 error

function qc_medical_history_endpoint()
{

    add_rewrite_endpoint('medical-history', EP_ROOT | EP_PAGES);

}

add_action('init', 'qc_medical_history_endpoint');

// ------------------

// 2. Add new query var

function qc_medical_history_query_vars($vars)
{

    $vars[] = 'medical-history';

    return $vars;

}

add_filter('query_vars', 'qc_medical_history_query_vars', 0);

// ------------------

// 3. Insert the new endpoint into the My Account menu

function qc_medical_history_link_my_account($items)
{

    $items['medical-history'] = 'Medical History';

    return $items;

}

add_filter('woocommerce_account_menu_items', 'qc_medical_history_link_my_account');

// ------------------

// 4. Add content to the new tab

function qc_medical_history_content()
{


//    include 'medical-renewal-template.php';
    get_template_part( 'medical-renewal-template' );

}

add_action('woocommerce_account_medical-history_endpoint', 'qc_medical_history_content');

// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format

