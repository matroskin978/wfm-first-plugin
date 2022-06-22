<?php

/*
Plugin Name: Webformyself First Plugin
Plugin URI: https://webformyself.com
Description: Первый тестовый плагин
Version: 1.0
Author: Andrey Kudlay
Author URI: https://webformyself.com
*/

defined( 'ABSPATH' ) or die;

/*add_filter('the_title', function ($title, $post_id) {
	return mb_convert_case($title, MB_CASE_TITLE);
}, 10, 2);*/

define( 'WFM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once WFM_PLUGIN_DIR . 'funcs.php';

register_activation_hook( __FILE__, 'wfm_activation' );
register_deactivation_hook( __FILE__, 'wfm_deactivation' );

/*register_uninstall_hook( __FILE__, 'wfm_uninstall' );

function wfm_uninstall() {
	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS `{$wpdb->prefix}test`");
}*/
