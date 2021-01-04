<?php
/**
 * Plugin Name:  Internet Explorer Compatibility by WebMan
 * Plugin URI:   https://github.com/webmandesign/internet-explorer-compatibility
 * Description:  Provides compatibility JavaScript for CSS variables support in Internet Explorer browsers.
 * Version:      1.0.0
 * Author:       WebMan Design, Oliver Juhas
 * Author URI:   https://www.webmandesign.eu/
 * License:      GNU General Public License v3
 * License URI:  http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * GitHub Plugin URI:  https://github.com/webmandesign/internet-explorer-compatibility
 *
 * Update using GitHub Updater plugin.
 * @link  https://github.com/afragen/github-updater/releases
 *
 * @copyright  WebMan Design, Oliver Juhas
 * @license    GPL-3.0, https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @link  https://github.com/webmandesign/internet-explorer-compatibility
 * @link  https://www.webmandesign.eu
 *
 * @package  Internet Explorer Compatibility
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class WM_Internet_Explorer_Compatibility {

	/**
	 * Initialization.
	 *
	 * @since  1.0.0
	 *
	 * @return  void
	 */
	public static function init() {

		// Processing

			// Actions

				add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_ponyfill', -100 );

	} // /init

	/**
	 * Enqueue JavaScript compatibility ponyfill.
	 *
	 * This script has to be enqueued in the HTML head!
	 * And it must not be wrapped in IE conditional tag!
	 *
	 * @link  https://jhildenbiddle.github.io/css-vars-ponyfill/
	 * @link  https://docs.microsoft.com/en-us/previous-versions/windows/internet-explorer/ie-developer/compatibility/hh801214(v=vs.85)
	 *
	 * @since  1.0.0
	 */
	public static function enqueue_ponyfill() {

		// Requirements check

			/**
			 * @link  https://caniuse.com/#feat=css-variables
			 */
			if ( empty( $GLOBALS['is_IE'] ) ) {
				return;
			}


		// Processing

			/**
			 * @link  https://jhildenbiddle.github.io/css-vars-ponyfill/#/?id=installation
			 */
			wp_enqueue_script(
				'css-vars-ponyfill',
				'https://cdn.jsdelivr.net/npm/css-vars-ponyfill',
				array(),
				'latest'
			);

			/**
			 * @link  https://jhildenbiddle.github.io/css-vars-ponyfill/#/?id=usage
			 */
			wp_add_inline_script(
				'css-vars-ponyfill',
				'window.onload = function() {' . PHP_EOL .
				"\t" . 'cssVars( {' . PHP_EOL .
				"\t\t" . 'exclude: \'link:not([href^="' . esc_url_raw( get_theme_root_uri() ) . '"])\'' . PHP_EOL .
				"\t" . '} );' . PHP_EOL .
				'};'
			);

	} // /enqueue_ponyfill

} // /WM_Internet_Explorer_Compatibility

WM_Internet_Explorer_Compatibility::init();
