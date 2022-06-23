<?php

defined( 'ABSPATH' ) or die;

/*function wfm_activation() {
//	die("Плагин активирован");
	$site = get_home_url();
	wp_mail('mail@mail.com', 'Плагин активирован', "Плагин активирован на сайте {$site}");
}*/

function wfm_activation() {
	if ( PHP_MAJOR_VERSION < 8 ) {
		die( 'Для работы плагина необходима версия PHP >= 8' );
	}
	global $wpdb;
	$query = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}test` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
	$wpdb->query( $query );
}

function wfm_deactivation() {
	$site = get_home_url();
	wp_mail( 'mail@mail.com', 'Плагин деактивирован', "Плагин деактивирован на сайте {$site}" );
}

function wfm_add_admin_pages() {
	$hook_suffix = add_menu_page(
		__( 'WFM Settings Main Page', 'wfmfirst' ),
		__( 'WFM Settings', 'wfmfirst' ),
		'manage_options',
		'wfm-main-settings',
		'wfm_main_admin_page',
		'dashicons-welcome-learn-more',
//		3
	);

	add_submenu_page(
		'wfm-main-settings',
		__( 'WFM Settings Main Page', 'wfmfirst' ),
		__( 'WFM Main', 'wfmfirst' ),
		'manage_options',
		'wfm-main-settings',
	);

	$hook_suffix_sp1 = add_submenu_page(
		'wfm-main-settings',
		__( 'WFM Submenu Page', 'wfmfirst' ),
		__( 'WFM Submenu', 'wfmfirst' ),
		'manage_options',
		'wfm-subpage1',
		'wfm_subpage1'
	);

	add_action( "admin_print_scripts-{$hook_suffix}", 'wfm_scripts_admin2' );
	add_action( "admin_print_styles-{$hook_suffix}", 'wfm_styles_admin' );

	add_action( "admin_print_scripts-{$hook_suffix_sp1}", 'wfm_scripts_admin2' );
	add_action( "admin_print_styles-{$hook_suffix_sp1}", 'wfm_styles_admin' );
}

function wfm_main_admin_page() {
	require_once WFM_PLUGIN_DIR . 'templates/main-admin-page.php';
}

function wfm_subpage1() {
	require_once WFM_PLUGIN_DIR . 'templates/admin-subpage1.php';
}

function wfm_scripts_front() {
	wp_enqueue_style( 'wfm-front', plugins_url( '/assets/front/wfm-front.css', __FILE__ ) );
	wp_enqueue_script( 'wfm-front', plugins_url( '/assets/front/wfm-front.js', __FILE__ ), array( 'jquery' ), false, true );
}

function wfm_scripts_admin( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'toplevel_page_wfm-main-settings', 'wfm-settings_page_wfm-subpage1' ) ) ) {
		return;
	}
	wp_enqueue_style( 'wfm-admin', plugins_url( '/assets/admin/wfm-admin.css', __FILE__ ) );
	wp_enqueue_script( 'wfm-admin', plugins_url( '/assets/admin/wfm-admin.js', __FILE__ ), array( 'jquery' ), false, true );
}

function wfm_scripts_admin2() {
	wp_enqueue_script( 'wfm-admin', plugins_url( '/assets/admin/wfm-admin.js', __FILE__ ), array( 'jquery' ), false, true );
}

function wfm_styles_admin() {
	wp_enqueue_style( 'wfm-admin', plugins_url( '/assets/admin/wfm-admin.css', __FILE__ ) );
}
