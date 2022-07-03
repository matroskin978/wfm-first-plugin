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

add_action( 'plugins_loaded', 'wfm_load_textdomain' );
add_action( 'admin_menu', 'wfm_add_admin_pages' );
add_action( 'wp_enqueue_scripts', 'wfm_scripts_front' );
//add_action( 'admin_enqueue_scripts', 'wfm_scripts_admin' );
add_action( 'admin_init', 'wfm_add_settings' );

add_action( 'init', 'wfm_add_post_type' );
add_filter( 'template_include', 'wfm_get_theme_template' );
// https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wfm_add_plugin_links' );

add_shortcode( 'wfmtest', 'wfmtest_shortcode' );
add_shortcode( 'wfmtest_content', 'wfmtest_content_shortcode' );

function gutenberg_examples_01_register_block() {
	register_block_type( __DIR__ . '/blocks/block1' );
}

//add_action( 'init', 'gutenberg_examples_01_register_block' );

//add_action( 'init', 'wfm_block_block2' );
function wfm_block_block2() {
	register_block_type( __DIR__ . '/blocks/block2' );
}

add_action( 'init', 'wfm_block_block3' );
function wfm_block_block3() {
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	wp_register_script( 'wfm-block3', plugins_url( 'blocks/block3/block.js', __FILE__ ), array(
		'wp-blocks',
		'wp-element',
		'wp-editor'
	) );
	wp_register_style( 'wfm-block3-editor', plugins_url( 'blocks/block3/editor.css', __FILE__ ) );
	wp_register_style( 'wfm-block3-style', plugins_url( 'blocks/block3/style.css', __FILE__ ) );

	register_block_type( 'wfm-block/block3', array(
		'editor_script' => 'wfm-block3',
		'editor_style'  => 'wfm-block3-editor',
		'style'         => 'wfm-block3-style',
	) );
}

add_action( 'add_meta_boxes', 'wfm_add_metaboxes' );
add_action( 'save_post', 'wfm_save_metaboxes' );
