<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ridwan-arifandi
 * @since      1.0.0
 *
 * @package    Aion_Popup
 * @subpackage Aion_Popup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Aion_Popup
 * @subpackage Aion_Popup/admin
 * @author     Ridwan Arifandi <orangerdigiart@gmail.com>
 */
class Aion_Popup_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the custom post type for the plugin.
	 *
	 * @since    1.0.0
	 * @return void
	 */
	public function register_custom_post_type() {

		register_post_type( AION_CUSTOM_POST_TYPE, array(
			'labels' => array(
				'name' => __( 'Chat Options', 'aion-popup' ),
				'singular_name' => __( 'Chat Option', 'aion-popup' ),
				'add_new' => __( 'Add New Option', 'aion-popup' ),
				'add_new_item' => __( 'Add New Chat Option', 'aion-popup' ),
				'edit_item' => __( 'Edit Chat Option', 'aion-popup' ),
				'new_item' => __( 'New Chat Option', 'aion-popup' ),
				'view_item' => __( 'View Chat Option', 'aion-popup' ),
				'search_items' => __( 'Search Chat Options', 'aion-popup' ),
				'not_found' => __( 'No chat options found', 'aion-popup' ),
				'not_found_in_trash' => __( 'No chat options found in trash', 'aion-popup' ),
				'parent_item_colon' => __( 'Parent Chat Option:', 'aion-popup' ),
				'menu_name' => __( 'Chat Options', 'aion-popup' ),
			),
			'public' => true,
			'has_archive' => true,
			'exclude_from_search' => true,
			'show_in_nav_menus' => false,
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'page-attributes' ),
			'menu_icon' => 'dashicons-format-chat',
			'rewrite' => array( 'slug' => 'aion-options' ),
		) );
	}

	// Meta box functionality has been replaced by Carbon Fields

}
