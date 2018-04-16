<?php
class TinyMCE_addWebinarButtonCLass{

	function setup_tinymce_plugin() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		if ( get_user_option( 'rich_editing' ) !== 'true' ) {
			return;
		}

		// Setup some filters
		add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin' ) );
		add_filter( 'mce_buttons', array( &$this, 'add_tinymce_toolbar_button' ) );
	}

	function add_tinymce_plugin( $plugin_array ) {
		$plugin_array['custom_link_class'] = plugin_dir_url( __FILE__ ) . 'tinymce-addwebinar.js';
		return $plugin_array;
	}

	function add_tinymce_toolbar_button( $buttons ) {
		array_push( $buttons, '|', 'custom_link_class' );
		return $buttons;
	}

	function __construct() {
		if ( is_admin() ) {
    		add_action( 'init', array(  $this, 'setup_tinymce_plugin' ) );
		}
  }
	
}

$tinyMCE_addWebinarButton = new TinyMCE_addWebinarButtonClass;

?>
