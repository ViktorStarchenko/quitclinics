<?php
/*
Plugin Name: Retina @2x
Description: A simple and lightweight plugin that will automatically look for retina images that end with "@2x".
Author: Wouter Postma
Author URI: https://wouterpostma.nl/
Plugin URI: https://wouterpostma.nl/
Version: 1.6
*/


function load_js_file()
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('the_js', plugins_url('/retina.js',__FILE__) );
}

add_action('wp_head', 'load_js_file');

?>