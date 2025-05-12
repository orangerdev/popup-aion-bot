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

		// Add active option if not main menu
		if (state.currentLevel !== "main") {
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
			html += `<a href="${content.download_url}" class="aion-action-button" target="_blank">↓ Download Brochure</a>`;
		}

		if (content.direct_link) {
			html += `<a href="${content.direct_link}" class="aion-action-button" target="_blank">↗ Direct Link</a>`;
		}

		html += "</div>";

		$options.html(html);
	}
})(jQuery);
