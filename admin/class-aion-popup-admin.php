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

	/**
	 * Register meta boxes for the custom post type.
	 *
	 * @since    1.0.0
	 * @return void
	 */
	public function register_meta_boxes() {
		add_meta_box(
			'aion_option_meta_box',
			__( 'Chat Option Settings', 'aion-popup' ),
			array( $this, 'render_meta_box' ),
			AION_CUSTOM_POST_TYPE,
			'normal',
			'high'
		);
	}

	/**
	 * Render the meta box.
	 *
	 * @since    1.0.0
	 * @param    WP_Post    $post    The post object.
	 * @return void
	 */
	public function render_meta_box( $post ) {
		// Add nonce for security
		wp_nonce_field( 'aion_option_meta_box', 'aion_option_meta_box_nonce' );

		// Get the meta values
		$download_url = get_post_meta( $post->ID, 'aion_download_url', true );
		$direct_link = get_post_meta( $post->ID, 'aion_direct_link', true );

		// Output the fields
		?>
		<p>
			<label for="aion_download_url"><?php _e( 'Download URL', 'aion-popup' ); ?>:</label>
			<input type="url" id="aion_download_url" name="aion_download_url" value="<?php echo esc_url( $download_url ); ?>"
				class="widefat">
			<span
				class="description"><?php _e( 'Enter the URL for the downloadable file (e.g., brochure)', 'aion-popup' ); ?></span>
		</p>
		<p>
			<label for="aion_direct_link"><?php _e( 'Direct Link', 'aion-popup' ); ?>:</label>
			<input type="url" id="aion_direct_link" name="aion_direct_link" value="<?php echo esc_url( $direct_link ); ?>"
				class="widefat">
			<span class="description"><?php _e( 'Enter a direct link to an external resource', 'aion-popup' ); ?></span>
		</p>
		<?php
	}

	/**
	 * Save the meta box data.
	 *
	 * @since    1.0.0
	 * @param    int       $post_id    The post ID.
	 * @return void
	 */
	public function save_meta_box( $post_id ) {
		// Check if our nonce is set
		if ( ! isset( $_POST['aion_option_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid
		if ( ! wp_verify_nonce( $_POST['aion_option_meta_box_nonce'], 'aion_option_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Sanitize and save the data
		if ( isset( $_POST['aion_download_url'] ) ) {
			update_post_meta( $post_id, 'aion_download_url', esc_url_raw( $_POST['aion_download_url'] ) );
		}

		if ( isset( $_POST['aion_direct_link'] ) ) {
			update_post_meta( $post_id, 'aion_direct_link', esc_url_raw( $_POST['aion_direct_link'] ) );
		}
	}

}
