<div class="wrap">
	<h1><?php _e( 'General settings', 'wfmfirst' ) ?></h1>

    <?php settings_errors(); ?>
    <form action="options.php" method="post">

        <?php settings_fields( 'wfm_main_group' ); ?>

        <?php do_settings_sections( 'wfm-main-settings' ); ?>

        <?php submit_button(); ?>

    </form>

</div>
