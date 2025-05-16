<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://ridwan-arifandi
 * @since      1.0.0
 *
 * @package    Aion_Popup
 * @subpackage Aion_Popup/public/partials
 */

// Get plugin options from Carbon Fields
$title = Aion_Popup_Carbon::get_plugin_option( 'aion_chatbot_title', 'AION ChatBot' );
$description = Aion_Popup_Carbon::get_plugin_option( 'aion_chatbot_description', 'Asisten virtual untuk info cepat dan mudah seputar mobil listrik AION.' );
$greeting = Aion_Popup_Carbon::get_plugin_option( 'aion_chatbot_greeting', "Halo! Selamat datang di AION ChatBot.🚗\nSaya siap membantu Anda mendapatkan informasi seputar:" );
$footer = Aion_Popup_Carbon::get_plugin_option( 'aion_chatbot_footer', 'GAC Indonesia' );

// Split greeting into paragraphs
$greeting_parts = explode( "\n", $greeting );
?>

<!-- AION ChatBot Popup -->
<div id="aion-chatbot-popup" class="aion-chatbot-popup">
	<div class="aion-chatbot-header">
		<div class="aion-chatbot-logo">
			<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/aion-logo.svg" alt="AION Logo">
		</div>
		<h2 class="header-title"><?php echo esc_html( $title ); ?></h2>
		<p class="header-description"><?php echo esc_html( $description ); ?></p>
	</div>

	<div class="aion-chatbot-content">
		<div class="aion-chatbot-message">
			<div class="aion-chatbot-avatar">
				<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/aion-logo.svg" alt="AION Logo">
			</div>
			<div class="aion-chatbot-text">
				<?php foreach ( $greeting_parts as $part ) : ?>
					<p><?php echo esc_html( $part ); ?></p>
				<?php endforeach; ?>

				<div class="aion-chatbot-options" id="aion-main-options">
					<!-- Options will be loaded dynamically via JavaScript -->
					<div class="aion-loading">Loading options...</div>
				</div>

				<div class="aion-chatbot-navigation" style="display: none;">
					<button class="aion-back-button">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15 6L9 12L15 18" stroke="#222" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg> Back
					</button>
					<button class="aion-main-menu-button">Main Menu</button>
				</div>
			</div>
		</div>
	</div>

	<div class="aion-chatbot-footer">
		<p><?php echo esc_html( $footer ); ?></p>
	</div>
</div>

<!-- Close Button -->
<button class="aion-chatbot-close" aria-label="Close">
	<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/close.svg" alt="Chat Bot" />
</button>

<!-- AION ChatBot Trigger Button -->
<div class="aion-chatbot-trigger">
	<!-- <div class="aion-trigger-buttons">
		<button class="aion-trigger-button aion-brochure-button">
			<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/brochure-icon.png" alt="Brochure">
		</button>
		<button class="aion-trigger-button aion-location-button">
			<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/location-icon.png" alt="Location">
		</button>
		<button class="aion-trigger-button aion-whatsapp-button">
			<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/whatsapp-icon.png" alt="WhatsApp">
		</button>
		<button class="aion-trigger-button aion-test-drive-button">
			<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/test-drive-icon.png" alt="Test Drive">
		</button>
	</div> -->
	<button class="aion-chatbot-toggle">
		<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/chatbot.svg" alt="Chat Bot" />
	</button>
</div>