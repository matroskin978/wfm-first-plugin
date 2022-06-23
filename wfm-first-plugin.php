<?php

/*
Plugin Name: Webformyself First Plugin
Plugin URI: https://webformyself.com
Description: Первый тестовый плагин
Version: 1.0
Author: Andrey Kudlay
Author URI: https://webformyself.com
Text Domain: wfmfirst
Domain Path: /languages/
*/

defined( 'ABSPATH' ) or die;

define( 'WFM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once WFM_PLUGIN_DIR . 'funcs.php';

register_activation_hook( __FILE__, 'wfm_activation' );
register_deactivation_hook( __FILE__, 'wfm_deactivation' );

add_action( 'admin_menu', 'wfm_add_admin_pages' );
