=== AION Popup Chatbot ===
Contributors: ridwanarifandi
Donate link: https://ridwan-arifandi/
Tags: chatbot, popup, aion, electric vehicles, customer support
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin that adds a floating chatbot popup to your website for providing information about AION electric vehicles.

== Description ==

AION Popup Chatbot is a WordPress plugin designed to enhance user engagement on websites featuring AION electric vehicles. The plugin creates a floating chatbot interface that appears on all pages of your WordPress site, providing visitors with easy access to information about AION vehicles and services.

= Key Features =

* **Floating Chatbot Interface**: Appears on all pages without requiring shortcodes
* **Hierarchical Navigation**: Organizes information in an intuitive, nested menu structure
* **Quick Access Buttons**: Provides direct access to brochures, location information, WhatsApp contact, and test drive scheduling
* **Responsive Design**: Works seamlessly on both desktop and mobile devices
* **Easy Content Management**: Uses WordPress custom post types for simple content updates
* **Back and Main Menu Navigation**: Allows users to easily navigate through the chatbot options

== Installation ==

1. Upload the `popup-aion-bot` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your chatbot content by creating entries in the 'Chat Options' section of the WordPress admin
4. The chatbot will automatically appear on all pages of your site

== Frequently Asked Questions ==

= How do I add content to the chatbot? =

Create entries in the 'Chat Options' custom post type. You can create a hierarchical structure by setting parent-child relationships between posts.

= Can I customize the appearance of the chatbot? =

Yes, you can modify the CSS in the `public/css/aion-popup-public.css` file to match your website's design.

= Does the chatbot work on mobile devices? =

Yes, the chatbot is fully responsive and works well on both desktop and mobile devices.

= Can I add links to external resources? =

Yes, each chat option can include download URLs or direct links using the custom fields provided in the edit screen.

== Screenshots ==

1. The AION Chatbot popup interface showing the main menu options
2. The floating chatbot button in the bottom-right corner of the website
3. Example of hierarchical navigation within the chatbot
4. Quick access buttons for brochures, location, WhatsApp, and test drive scheduling

== Changelog ==

= 1.0.0 =
* Initial release
* Floating chatbot interface with toggle button
* Hierarchical navigation system
* Quick access buttons for key information
* Responsive design for all devices

== Upgrade Notice ==

= 1.0.0 =
Initial release of the AION Popup Chatbot plugin.

== Content Structure ==

The plugin uses a custom post type called 'aion_options' to organize the chatbot content:

1. **Parent Options**: Create top-level menu items as parent posts
2. **Child Options**: Create sub-menu items by setting a parent for the post
3. **Content**: Add detailed information in the post editor
4. **Additional Links**: Add download URLs or direct links using the custom fields

== Customization ==

= Images =

The plugin requires the following images in the `public/images` folder:

1. `aion-logo.png` - The AION logo used in the header and avatar
2. `wave-pattern.png` - Background pattern for the header
3. `brochure-icon.png` - Icon for the brochure button
4. `location-icon.png` - Icon for the location button
5. `whatsapp-icon.png` - Icon for the WhatsApp button
6. `test-drive-icon.png` - Icon for the test drive button
7. `chatbot-icon.png` - Icon for the main chatbot toggle button
8. `close-icon.png` - Icon for the close button

= CSS Styling =

You can customize the appearance of the chatbot by modifying the CSS in `public/css/aion-popup-public.css`.