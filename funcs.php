<?php

defined( 'ABSPATH' ) or die;

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

	wfm_add_post_type();
	flush_rewrite_rules();
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

function wfm_load_textdomain() {
	load_plugin_textdomain( 'wfmfirst', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function wfm_add_settings() {
	// register settins
	register_setting( 'wfm_main_group', 'wfm_main_email' );
	register_setting( 'wfm_main_group', 'wfm_main_name' );
	register_setting( 'wfm_subpage1_group', 'wfm_subpage1_phone' );

	// add sections
	add_settings_section(
		'wfm_main_first_section',
		__( 'Main Section 1', 'wfmfirst' ),
		function () {
			echo '<p>' . __( 'Main Section 1 description...' ) . '</p>';
		},
		'wfm-main-settings'
	);
	add_settings_section(
		'wfm_main_second_section',
		__( 'Main Section 2', 'wfmfirst' ),
		function () {
			echo '<p>' . __( 'Main Section 2 description...' ) . '</p>';
		},
		'wfm-main-settings'
	);
	add_settings_section(
		'wfm_subpage1_first_section',
		__( 'Subpage Section 1', 'wfmfirst' ),
		function () {
			echo '<p>' . __( 'Subpage Section 1 description...' ) . '</p>';
		},
		'wfm-subpage1'
	);

	// add settings
	add_settings_field(
		'wfm_main_email',
		__( 'E-mail', 'wfmfirst' ),
		'wfm_main_email_field',
		'wfm-main-settings',
		'wfm_main_first_section',
		array( 'label_for' => 'wfm_main_email' )
	);
	add_settings_field(
		'wfm_main_name',
		__( 'Name', 'wfmfirst' ),
		'wfm_main_name_field',
		'wfm-main-settings',
		'wfm_main_second_section',
		array( 'label_for' => 'wfm_main_name' )
	);
	add_settings_field(
		'wfm_subpage1_phone',
		__( 'Phone', 'wfmfirst' ),
		'wfm_subpage1_phone_field',
		'wfm-subpage1',
		'wfm_subpage1_first_section',
		array( 'label_for' => 'wfm_subpage1_phone' )
	);
}

function wfm_main_email_field() {
	echo '<input name="wfm_main_email" id="wfm_main_email" type="email" value="' . esc_attr( get_option( 'wfm_main_email' ) ) . '" class="regular-text code">';
}

function wfm_main_name_field() {
	echo '<input name="wfm_main_name" id="wfm_main_name" type="text" value="' . esc_attr( get_option( 'wfm_main_name' ) ) . '" class="regular-text code">';
}

function wfm_subpage1_phone_field() {
	echo '<input name="wfm_subpage1_phone" id="wfm_subpage1_phone" type="text" value="' . esc_attr( get_option( 'wfm_subpage1_phone' ) ) . '" class="regular-text code">';
}

function wfm_add_post_type() {
	register_taxonomy( 'genre', 'book', array(
//		'label' => __( 'Genres', 'wfmfirst' ),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'books/genre' ),
		'labels'            => array(
			'name'          => __( 'Genres', 'wfmfirst' ),
			'singular_name' => __( 'Genre', 'wfmfirst' ),
			'all_items'     => __( 'All Genres', 'wfmfirst' ),
			'edit_item'     => __( 'Edit Genre', 'wfmfirst' ),
			'update_item'   => __( 'Update Genre', 'wfmfirst' ),
			'add_new_item'  => __( 'Add New Genre', 'wfmfirst' ),
			'new_item_name' => __( 'New Genre Name', 'wfmfirst' ),
			'menu_name'     => __( 'Genre', 'wfmfirst' ),
		),
	) );

	register_post_type( 'book', array(
		'label'        => __( 'Books', 'wfmfirst' ),
		'public'       => true,
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'books' ),
		'show_in_rest' => true,
	) );
}

function wfm_get_theme_template( $template ) {
	if ( is_singular( 'book' ) ) {
		if ( ! file_exists( get_template_directory() . '/single-book.php' ) ) {
			return WFM_PLUGIN_DIR . 'templates/front/single-book.php';
		}
	}

	if ( is_post_type_archive( 'book' ) ) {
		if ( ! file_exists( get_template_directory() . '/archive-book.php' ) ) {
			return WFM_PLUGIN_DIR . 'templates/front/archive-book.php';
		}
	}

	if ( is_tax( 'genre' ) ) {
		if ( ! file_exists( get_template_directory() . '/taxonomy-genre.php' ) ) {
			return WFM_PLUGIN_DIR . 'templates/front/taxonomy-genre.php';
		}
	}

	return $template;
}

function wfm_add_plugin_links( $links ) {
	$new_links = array( '<a href="' . admin_url( 'admin.php?page=wfm-main-settings' ) . '">' . __( 'WFM Settings', 'wfmfirst' ) . '</a>' );
	$links     = array_merge( $links, $new_links );

	return $links;
}

function wfmtest_shortcode( $atts ) {
	$atts = shortcode_atts( array (
		'tag' => 'h3',
		'class' => 'wfm-test',
	), $atts );
	$tag = esc_html( $atts['tag'] );
	$class = esc_html( $atts['class'] );

	return "<{$tag} class='{$class}'>Привет! Я - shortcode.</{$tag}>";
}

function wfmtest_content_shortcode( $atts, $content ) {
	$atts = shortcode_atts( array (
		'tag' => 'h5',
		'class' => 'wfm-test2',
	), $atts );
	$tag = esc_html( $atts['tag'] );
	$class = esc_html( $atts['class'] );

	return "<{$tag} class='{$class}'>{$content}</{$tag}>";
}

function wfm_add_metaboxes() {
	add_meta_box( 'wfm_book_info', __( 'Book info', 'wfmfirst' ), 'wfm_book_info_cb', array( 'book' ) );
}

function wfm_book_info_cb( $post ) {
	wp_nonce_field( 'wfm_action', 'wfm_nonce' );
	$book_pages = get_post_meta( $post->ID, 'book_pages', true );
	$book_cover = get_post_meta( $post->ID, 'book_cover', true );
	?>

	<table class="form-table">
		<tbody>

		<tr>
			<th><label for="book_pages"><?php _e( 'Number of pages', 'wfmfirst' ) ?></label></th>
			<td><input type="text" id="book_pages" name="book_pages" class="regular-text"
			           value="<?php echo esc_attr( $book_pages ) ?>"></td>
		</tr>

		<tr>
			<th><label for="book_cover"><?php _e( 'Cover?', 'wfmfirst' ) ?></label></th>
			<td><input type="checkbox" id="book_cover" name="book_cover" <?php checked( 'yes', $book_cover ) ?>></td>
		</tr>

		</tbody>
	</table>

	<?php
}

function wfm_save_metaboxes( $post_id ) {
	if ( ! isset( $_POST['wfm_nonce'] ) || ! wp_verify_nonce( $_POST['wfm_nonce'], 'wfm_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( ! empty( $_POST['book_pages'] ) ) {
		update_post_meta( $post_id, 'book_pages', sanitize_text_field( $_POST['book_pages'] ) );
	} else {
		delete_post_meta( $post_id, 'book_pages' );
	}

	if ( isset( $_POST['book_cover'] ) && $_POST['book_cover'] == 'on' ) {
		update_post_meta( $post_id, 'book_cover', 'yes' );
	} else {
		delete_post_meta( $post_id, 'book_cover' );
	}
}
