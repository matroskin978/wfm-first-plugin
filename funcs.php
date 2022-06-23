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
	$wpdb->query($query);
}

function wfm_deactivation() {
	$site = get_home_url();
	wp_mail('mail@mail.com', 'Плагин деактивирован', "Плагин деактивирован на сайте {$site}");
}

function wfm_add_admin_pages() {
	add_menu_page(
		__('WFM Settings Main Page', 'wfmfirst'),
		__('WFM Settings', 'wfmfirst'),
		'manage_options',
		'wfm-main-settings',
		'wfm_main_admin_page',
		'dashicons-welcome-learn-more',
//		3
	);

	add_submenu_page(
		'wfm-main-settings',
		__('WFM Settings Main Page', 'wfmfirst'),
		__('WFM Main', 'wfmfirst'),
		'manage_options',
		'wfm-main-settings',
	);

	add_submenu_page(
		'wfm-main-settings',
		__('WFM Submenu Page', 'wfmfirst'),
		__('WFM Submenu', 'wfmfirst'),
		'manage_options',
		'wfm-subpage1',
		'wfm_subpage1'
	);
}

function wfm_main_admin_page() {
	require_once WFM_PLUGIN_DIR . 'templates/main-admin-page.php';
}

function wfm_subpage1() {
	require_once WFM_PLUGIN_DIR . 'templates/admin-subpage1.php';
}
