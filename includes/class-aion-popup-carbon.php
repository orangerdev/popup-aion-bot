<?php

/**
 * The Carbon Fields integration file
 *
 * This file handles the integration with Carbon Fields library
 * and defines the fields for the plugin.
 *
 * @link       https://ridwan-arifandi
 * @since      1.0.0
 *
 * @package    Aion_Popup
 * @subpackage Aion_Popup/includes
 */

/**
 * The Carbon Fields integration class.
 *
 * This is used to define Carbon Fields integration and fields.
 *
 * @since      1.0.0
 * @package    Aion_Popup
 * @subpackage Aion_Popup/includes
 * @author     Ridwan Arifandi <orangerdigiart@gmail.com>
 */
class Aion_Popup_Carbon {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Hook into the Carbon Fields boot
		add_action( 'after_setup_theme', array( $this, 'load_carbon_fields' ) );
		add_action( 'carbon_fields_register_fields', array( $this, 'register_plugin_options' ) );
		add_action( 'carbon_fields_register_fields', array( $this, 'register_post_meta' ) );
	}

	/**
	 * Load Carbon Fields
	 *
	 * @since    1.0.0
	 */
	public function load_carbon_fields() {
		\Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 * Register plugin options
	 *
	 * @since    1.0.0
	 */
	public function register_plugin_options() {
		\Carbon_Fields\Container::make( 'theme_options', __( 'Settings', 'aion-popup' ) )
			->set_page_parent( 'edit.php?post_type=' . AION_CUSTOM_POST_TYPE )
			->add_fields( array(
				\Carbon_Fields\Field::make( 'text', 'aion_chatbot_title', __( 'ChatBot Title', 'aion-popup' ) )
					->set_default_value( 'AION ChatBot' )
					->set_help_text( __( 'The title displayed in the chatbot header', 'aion-popup' ) ),

				\Carbon_Fields\Field::make( 'textarea', 'aion_chatbot_description', __( 'ChatBot Description', 'aion-popup' ) )
					->set_default_value( 'Asisten virtual untuk info cepat dan mudah seputar mobil listrik AION.' )
					->set_help_text( __( 'The description displayed in the chatbot header', 'aion-popup' ) ),

				\Carbon_Fields\Field::make( 'textarea', 'aion_chatbot_greeting', __( 'ChatBot Greeting', 'aion-popup' ) )
					->set_default_value( "Halo! Selamat datang di AION ChatBot.🚗\nSaya siap membantu Anda mendapatkan informasi seputar:" )
					->set_help_text( __( 'The greeting message displayed when the chatbot is opened', 'aion-popup' ) ),

				\Carbon_Fields\Field::make( 'text', 'aion_chatbot_footer', __( 'ChatBot Footer', 'aion-popup' ) )
					->set_default_value( 'GAC Indonesia' )
					->set_help_text( __( 'The text displayed in the chatbot footer', 'aion-popup' ) ),
			) );
	}

	/**
	 * Register post meta fields
	 *
	 * @since    1.0.0
	 */
	public function register_post_meta() {
		\Carbon_Fields\Container::make( 'post_meta', __( 'Chat Option Settings', 'aion-popup' ) )
			->where( 'post_type', '=', AION_CUSTOM_POST_TYPE )
			->add_fields( array(
				\Carbon_Fields\Field::make( 'url', 'aion_download_url', __( 'Download URL', 'aion-popup' ) )
					->set_help_text( __( 'Enter the URL for the downloadable file (e.g., brochure)', 'aion-popup' ) ),

				\Carbon_Fields\Field::make( 'url', 'aion_direct_link', __( 'Direct Link', 'aion-popup' ) )
					->set_help_text( __( 'Enter a direct link to an external resource', 'aion-popup' ) ),
			) );
	}

	/**
	 * Helper function to get plugin option
	 *
	 * @since    1.0.0
	 * @param    string    $option_name    The option name
	 * @param    mixed     $default        Default value if option is not set
	 * @return   mixed     The option value
	 */
	public static function get_plugin_option( $option_name, $default = '' ) {
		$value = carbon_get_theme_option( $option_name );
		return ! empty( $value ) ? $value : $default;
	}

	/**
	 * Helper function to get post meta
	 *
	 * @since    1.0.0
	 * @param    int       $post_id        The post ID
	 * @param    string    $meta_key       The meta key
	 * @param    mixed     $default        Default value if meta is not set
	 * @return   mixed     The meta value
	 */
	public static function get_post_meta( $post_id, $meta_key, $default = '' ) {
		$value = carbon_get_post_meta( $post_id, $meta_key );
		return ! empty( $value ) ? $value : $default;
	}
}
