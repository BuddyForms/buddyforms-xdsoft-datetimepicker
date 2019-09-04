<?php
/*
 * Plugin Name: BuddyForms XDSoft DateTimePicker
 * Plugin URI: http://buddyforms.com/
 * Description: Integrate an amazing Calendar component into your Forms.
 * Version: 1.0.0
 * Author: ThemeKraft
 * Author URI: https://profiles.wordpress.org/gfirem
 * License: GPLv2 or later
 *
 * @package bf_xdsoft_datetimepicker
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'buddyforms_xdsoft_datetimepicker' ) ) {

	class buddyforms_xdsoft_datetimepicker {

		/**
		 * Instance of this class
		 *
		 * @var $instance bf_woo_elem
		 */
		protected static $instance = null;
		public static $assets;
		public static $view;
		public static $classes;
		public static $slug = 'buddyforms_xdsoft_datetimepicker';
		public static $version = '1.0.0';

		private function __construct() {
			$this->constants();
			if ( self::is_buddy_form_active() ) {
				require_once 'includes/class-bf-xdsoft-datetimepicker-element-date.php';
				require_once 'includes/class-bf-xdsoft-datetimepicker-element-time.php';
				require_once 'includes/class-bf-xdsoft-datetimepicker-element.php';
				new buddyforms_xdsoft_datetimepicker_element();
			}
		}

		public static function load_plugins_dependency() {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		public static function is_buddy_form_active() {
			self::load_plugins_dependency();

			return is_plugin_active( 'buddyforms-premium/BuddyForms.php' ) || is_plugin_active( 'buddyforms/BuddyForms.php' );
		}

		private function constants() {
			self::$assets  = plugin_dir_url( __FILE__ ) . 'assets/';
			self::$view    = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
			self::$classes = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

	}

	add_action( 'plugins_loaded', array( 'buddyforms_xdsoft_datetimepicker', 'get_instance' ), 1 );
}