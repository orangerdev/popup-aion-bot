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
?>

<!-- AION ChatBot Popup -->
<div id="aion-chatbot-popup" class="aion-chatbot-popup">
	<div class="aion-chatbot-header">
		<div class="aion-chatbot-logo">
			<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/aion-logo.png" alt="AION Logo">
		</div>
		<div class="aion-chatbot-title">
			<h2>AION ChatBot</h2>
			<p>Asisten virtual untuk info cepat dan mudah seputar mobil listrik AION.</p>
		</div>
	</div>

	<div class="aion-chatbot-content">
		<div class="aion-chatbot-message">
			<div class="aion-chatbot-avatar">
				<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/aion-logo.png" alt="AION Logo">
			</div>
			<div class="aion-chatbot-text">
				<p>Halo! Selamat datang di AION ChatBot 🚗</p>
				<p>Saya siap membantu Anda mendapatkan informasi seputar:</p>
			</div>
		</div>

		<div class="aion-chatbot-options" id="aion-main-options">
			<!-- Options will be loaded dynamically via JavaScript -->
			<div class="aion-loading">Loading options...</div>
		</div>

		<div class="aion-chatbot-navigation" style="display: none;">
			<button class="aion-back-button"><span>&#8592;</span> Back</button>
			<button class="aion-main-menu-button">Main Menu</button>
		</div>
	</div>

	<div class="aion-chatbot-footer">
		<p>GAC Indonesia</p>
	</div>

	<button class="aion-chatbot-close">
		<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/close-icon.png" alt="Close">
	</button>
</div>

<!-- AION ChatBot Trigger Button -->
<div class="aion-chatbot-trigger">
	<div class="aion-trigger-buttons">
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
	</div>
	<button class="aion-chatbot-toggle">
		<img src="<?php echo AION_POPUP_PLUGIN_URL; ?>public/images/chatbot-icon.png" alt="Chat Bot">
	</button>
</div>