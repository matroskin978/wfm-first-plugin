<?php

/*function wfm_activation() {
//	die("Плагин активирован");
	$site = get_home_url();
	wp_mail('mail@mail.com', 'Плагин активирован', "Плагин активирован на сайте {$site}");
}*/

/*function wfm_activation() {
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
}*/
