<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ridwan-arifandi
 * @since      1.0.0
 *
 * @package    Aion_Popup
 * @subpackage Aion_Popup/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Aion_Popup
 * @subpackage Aion_Popup/public
 * @author     Ridwan Arifandi <orangerdigiart@gmail.com>
 */
class Aion_Popup_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aion-popup-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/aion-popup-public.js', array( 'jquery' ), $this->version, false );

		// Localize the script with new data
		wp_localize_script( $this->plugin_name, 'aion_popup_vars', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'aion_popup_nonce' ),
			'plugin_url' => AION_POPUP_PLUGIN_URL,
		) );
	}

	/**
	 * Register shortcode for the chatbot trigger (kept for backward compatibility)
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {
		add_shortcode( 'aion_chatbot', array( $this, 'chatbot_shortcode' ) );
	}

	/**
	 * Shortcode callback function (kept for backward compatibility)
	 *
	 * @since    1.0.0
	 * @param    array     $atts    Shortcode attributes
	 * @return   string    The shortcode output
	 */
	public function chatbot_shortcode( $atts = [] ) {
		// Return empty string, as the popup is now automatically added to the footer on all pages
		return '';
	}

	/**
	 * Add the chatbot popup to the footer
	 *
	 * @since    1.0.0
	 */
	public function add_popup_to_footer() {
		include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/aion-popup-public-display.php';
	}

	/**
	 * Create folder for images if it doesn't exist
	 *
	 * @since    1.0.0
	 */
	public function create_images_folder() {
		$images_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'public/images';

		if ( ! file_exists( $images_dir ) ) {
			wp_mkdir_p( $images_dir );
		}
	}

	/**
	 * AJAX handler for getting options
	 *
	 * @since    1.0.0
	 */
	public function get_options() {
		// Check nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'aion_popup_nonce' ) ) {
			wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
		}

		// Get parent ID
		$parent_id = isset( $_POST['parent'] ) ? intval( $_POST['parent'] ) : 0;

		// Get options
		$options = $this->get_chat_options( $parent_id );

		wp_send_json_success( $options );
	}

	/**
	 * AJAX handler for getting content
	 *
	 * @since    1.0.0
	 */
	public function get_content() {
		// Check nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'aion_popup_nonce' ) ) {
			wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
		}

		// Get option ID
		$option_id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;

		// Get content
		$content = $this->get_chat_content( $option_id );

		wp_send_json_success( $content );
	}

	/**
	 * Get chat options from the database
	 *
	 * @since    1.0.0
	 * @param    int       $parent_id    The parent ID
	 * @return   array     The chat options
	 */
	private function get_chat_options( $parent_id = 0 ) {
		$args = array(
			'post_type' => AION_CUSTOM_POST_TYPE,
			'posts_per_page' => -1,
			'post_parent' => $parent_id,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);

		$query = new WP_Query( $args );
		$options = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				// Check if this post has children
				$children_args = array(
					'post_type' => AION_CUSTOM_POST_TYPE,
					'posts_per_page' => 1,
					'post_parent' => get_the_ID(),
				);

				$children_query = new WP_Query( $children_args );
				$has_children = $children_query->have_posts();

				$options[] = array(
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'has_children' => $has_children,
				);
			}

			wp_reset_postdata();
		}

		return $options;
	}

	/**
	 * Get chat content from the database
	 *
	 * @since    1.0.0
	 * @param    int       $option_id    The option ID
	 * @return   array     The chat content
	 */
	private function get_chat_content( $option_id ) {
		$post = get_post( $option_id );

		if ( ! $post ) {
			return array(
				'content' => 'Content not found.',
				'download_url' => '',
				'direct_link' => '',
			);
		}

		// Get custom fields using Carbon Fields
		$download_url = Aion_Popup_Carbon::get_post_meta( $option_id, 'aion_download_url', '' );
		$direct_link = Aion_Popup_Carbon::get_post_meta( $option_id, 'aion_direct_link', '' );

		return array(
			'content' => apply_filters( 'the_content', $post->post_content ),
			'download_url' => $download_url,
			'direct_link' => $direct_link,
		);
	}

}
