(function ($) {
	"use strict";

	/**
	 * AION ChatBot Popup Functionality
	 */

	// Store the current state
	const state = {
		isOpen: false,
		currentLevel: "main",
		history: [],
		currentParent: 0,
	};

	// DOM Elements
	let $popup,
		$toggle,
		$triggerButtons,
		$options,
		$navigation,
		$backButton,
		$mainMenuButton,
		$closeButton;

	// Initialize the plugin
	$(function () {
		// Cache DOM elements
		$popup = $("#aion-chatbot-popup");
		$toggle = $(".aion-chatbot-toggle");
		$triggerButtons = $(".aion-trigger-buttons");
		$options = $("#aion-main-options");
		$navigation = $(".aion-chatbot-navigation");
		$backButton = $(".aion-back-button");
		$mainMenuButton = $(".aion-main-menu-button");
		$closeButton = $(".aion-chatbot-close");

		// Initialize event listeners
		initEventListeners();

		// Load initial options
		loadOptions(0);
	});

	/**
	 * Initialize event listeners
	 */
	function initEventListeners() {
		// Toggle popup
		$toggle.on("click", function () {
			togglePopup();
		});

		// Close popup
		$closeButton.on("click", function () {
			closePopup();
		});

		// Back button
		$backButton.on("click", function () {
			navigateBack();
		});

		// Main menu button
		$mainMenuButton.on("click", function () {
			navigateToMainMenu();
		});

		// Handle option clicks (delegated event)
		$options.on("click", ".aion-option-button", function () {
			const optionId = $(this).data("id");
			const hasChildren = $(this).data("has-children");
			const optionTitle = $(this).text();

			// Add to history
			state.history.push({
				id: state.currentParent,
				title:
					state.currentLevel === "main"
						? "Main Menu"
						: $(".aion-option-button.active").text(),
			});

			// Update active option
			$(".aion-option-button").removeClass("active");
			$(this).addClass("active");

			if (hasChildren) {
				// Load child options
				loadOptions(optionId);
				state.currentParent = optionId;
				state.currentLevel = optionTitle;
			} else {
				// Load content
				loadContent(optionId);
				state.currentLevel = optionTitle;
			}

			// Show navigation
			$navigation.show();
		});
	}

	/**
	 * Toggle the popup visibility
	 */
	function togglePopup() {
		if (state.isOpen) {
			closePopup();
		} else {
			openPopup();
		}
	}

	/**
	 * Open the popup
	 */
	function openPopup() {
		$popup.addClass("active");
		$toggle.addClass("active");
		$triggerButtons.addClass("active");
		state.isOpen = true;
	}

	/**
	 * Close the popup
	 */
	function closePopup() {
		$popup.removeClass("active");
		$toggle.removeClass("active");
		$triggerButtons.removeClass("active");
		state.isOpen = false;
	}

	/**
	 * Navigate back to the previous level
	 */
	function navigateBack() {
		if (state.history.length > 0) {
			const previous = state.history.pop();
			loadOptions(previous.id);
			state.currentParent = previous.id;
			state.currentLevel = previous.title;

			// Hide navigation if we're back at the main menu
			if (state.history.length === 0) {
				$navigation.hide();
			}
		}
	}

	/**
	 * Navigate to the main menu
	 */
	function navigateToMainMenu() {
		// Clear history
		state.history = [];
		state.currentParent = 0;
		state.currentLevel = "main";

		// Load main options
		loadOptions(0);

		// Hide navigation
		$navigation.hide();
	}

	/**
	 * Load options from the server
	 * @param {number} parentId - The parent ID to load children for
	 */
	function loadOptions(parentId) {
		$options.html('<div class="aion-loading">Loading options...</div>');

		// AJAX request to get options
		$.ajax({
			url: aion_popup_vars.ajax_url,
			type: "POST",
			data: {
				action: "aion_get_options",
				parent: parentId,
				nonce: aion_popup_vars.nonce,
			},
			success: function (response) {
				if (response.success) {
					renderOptions(response.data);
				} else {
					$options.html(
						'<div class="aion-error">Error loading options. Please try again.</div>',
					);
				}
			},
			error: function () {
				$options.html(
					'<div class="aion-error">Error loading options. Please try again.</div>',
				);
			},
		});
	}

	/**
	 * Load content for a specific option
	 * @param {number} optionId - The option ID to load content for
	 */
	function loadContent(optionId) {
		$options.html('<div class="aion-loading">Loading content...</div>');

		// AJAX request to get content
		$.ajax({
			url: aion_popup_vars.ajax_url,
			type: "POST",
			data: {
				action: "aion_get_content",
				id: optionId,
				nonce: aion_popup_vars.nonce,
			},
			success: function (response) {
				if (response.success) {
					renderContent(response.data);
				} else {
					$options.html(
						'<div class="aion-error">Error loading content. Please try again.</div>',
					);
				}
			},
			error: function () {
				$options.html(
					'<div class="aion-error">Error loading content. Please try again.</div>',
				);
			},
		});
	}

	/**
	 * Render options in the popup
	 * @param {Array} options - The options to render
	 */
	function renderOptions(options) {
		if (options.length === 0) {
			$options.html('<div class="aion-empty">No options available.</div>');
			return;
		}

		let html = "";

		console.log({ state });

		// Add active option if not main menu
		if (state.currentLevel !== "main" && state.currentParent !== 0) {
			html += `<div class="aion-option-button active">${state.currentLevel}</div>`;
			html += "<hr>";
		}

		// Add options
		options.forEach(function (option) {
			html += `<button class="aion-option-button" data-id="${option.id}" data-has-children="${option.has_children}">${option.title}</button>`;
		});

		$options.html(html);
	}

	/**
	 * Render content in the popup
	 * @param {Object} content - The content to render
	 */
	function renderContent(content) {
		let html = "";

		// Add active option
		html += `<div class="aion-option-button active">${state.currentLevel}</div>`;
		html += '<div class="aion-option-content">';

		// Add content
		html += content.content;

		// Add action buttons if available
		if (content.download_url) {
			html += `<a href="${content.download_url}" class="aion-action-button" target="_blank">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M4 17V19C4 19.5304 4.21071 20.0391 4.58579 20.4142C4.96086 20.7893 5.46957 21 6 21H18C18.5304 21 19.0391 20.7893 19.4142 20.4142C19.7893 20.0391 20 19.5304 20 19V17M7 11L12 16M12 16L17 11M12 16V4" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
 Download Brochure
			</a>`;
		}

		if (content.direct_link) {
			html += `<a href="${content.direct_link}" class="aion-action-button" target="_blank">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.00001 14.9999L15 8.99994M11 5.99994L11.463 5.46394C12.4008 4.52627 13.6727 3.99954 14.9989 3.99963C16.325 3.99973 17.5968 4.52663 18.5345 5.46444C19.4722 6.40224 19.9989 7.67413 19.9988 9.00029C19.9987 10.3265 19.4718 11.5983 18.534 12.5359L18 12.9999M13 17.9999L12.603 18.5339C11.654 19.4716 10.3736 19.9975 9.03951 19.9975C7.70538 19.9975 6.42502 19.4716 5.47601 18.5339C5.00813 18.0717 4.63665 17.5211 4.38311 16.9142C4.12958 16.3074 3.99902 15.6562 3.99902 14.9984C3.99902 14.3407 4.12958 13.6895 4.38311 13.0826C4.63665 12.4757 5.00813 11.9252 5.47601 11.4629L6.00001 10.9999" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
 Direct Link
			</a>`;
		}

		html += "</div>";

		$options.html(html);
	}
})(jQuery);
