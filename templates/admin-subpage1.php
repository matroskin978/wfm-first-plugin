<div class="wrap">
	<h1><?php _e( 'Subpage 1', 'wfmfirst' ) ?></h1>

	<?php settings_errors(); ?>
    <form action="options.php" method="post">

		<?php settings_fields( 'wfm_subpage1_group' ); ?>

		<?php do_settings_sections( 'wfm-subpage1' ); ?>

		<?php submit_button(); ?>

    </form>

</div>
