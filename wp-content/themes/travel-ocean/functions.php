<?php
/**
 * Travel Ocean main functions and definitions.
 *
 * @link https://codex.wordpress.org/Child_Themes
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$travel_ocean_parent_dir_uri      = get_template_directory_uri();
$travel_ocean_parent_version      = wp_get_theme( 'storefront' )->get( 'Version' );
$travel_ocean_child_theme_dir     = get_stylesheet_directory();
$travel_ocean_child_theme_version = wp_get_theme()->get( 'Version' );
$travel_ocean_child_theme_dir_uri = get_stylesheet_directory_uri();

/**
 * Define constants.
 */
! defined( 'TRAVEL_OCEAN_PARENT_VERSION' ) ? define( 'TRAVEL_OCEAN_PARENT_VERSION', $travel_ocean_parent_version ) : false;
! defined( 'TRAVEL_OCEAN_PARENT_DIR_URI' ) ? define( 'TRAVEL_OCEAN_PARENT_DIR_URI', $travel_ocean_parent_dir_uri ) : false;
! defined( 'TRAVEL_OCEAN_CHILD_DIR' ) ? define( 'TRAVEL_OCEAN_CHILD_DIR', $travel_ocean_child_theme_dir ) : false;
! defined( 'TRAVEL_OCEAN_CHILD_VERSION' ) ? define( 'TRAVEL_OCEAN_CHILD_VERSION', $travel_ocean_child_theme_version ) : false;
! defined( 'TRAVEL_OCEAN_CHILD_DIR_URI' ) ? define( 'TRAVEL_OCEAN_CHILD_DIR_URI', $travel_ocean_child_theme_dir_uri ) : false;

if ( ! function_exists( 'travel_ocean_body_classes' ) ) {

	/**
	 * Add class to body.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function travel_ocean_body_classes( $classes ) {

		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		$user_agent = ! empty( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		/**
		 * Check browser type.
		 */
		if ( $is_lynx ) {
			$classes[] = 'lynx';
		} elseif ( $is_gecko ) {
			$classes[] = 'gecko';
		} elseif ( $is_opera ) {
			$classes[] = 'opera';
		} elseif ( $is_NS4 ) {
			$classes[] = 'ns4';
		} elseif ( $is_safari ) {
			$classes[] = 'safari';
		} elseif ( $is_chrome ) {
			$classes[] = 'chrome';
		} elseif ( $is_IE ) {
			$classes[] = 'ie';
		} else {
			$classes[] = 'unknown-browser';
		}

		/**
		 * Check platform or os type.
		 */
		if ( $is_iphone ) {
			$classes[] = 'iphone';
		}
		if ( stristr( $user_agent, 'mac' ) ) {
			$classes[] = 'mac';
		} elseif ( stristr( $user_agent, 'linux' ) ) {
			$classes[] = 'linux';
		} elseif ( stristr( $user_agent, 'windows' ) ) {
			$classes[] = 'windows';
		}

		if ( function_exists( 'is_wp_travel_archive_page' ) && is_wp_travel_archive_page() ) {
			$classes[] = 'travel-ocean-itinerary-archive';
		}

		if ( ! is_active_sidebar( 'wp-travel-archive-sidebar' ) ) {
			$classes[] = 'wp-travel-no-sidebar';
		} else {
			$classes[] = 'wp-travel-has-sidebar';
		}

		return $classes;
	}
	add_filter( 'body_class', 'travel_ocean_body_classes' );
}

/**
 * Include files.
 */
function travel_ocean_include_files() {

	$file_paths = array(
		'inc/assets',
		'inc/helpers',
		'inc/customizer/customizer',
		'inc/load-sections',
		'inc/tgm-plugin/tgmpa-hook',
	);

	$child_theme_dir = TRAVEL_OCEAN_CHILD_DIR;

	foreach ( $file_paths as $file_path ) {

		/**
		 * If wp_normalize_path function exists then use it to normalize
		 * the filesystem path according to the operating systems
		 * else use as it is.
		 */
		if ( function_exists( 'wp_normalize_path' ) ) {
			require_once wp_normalize_path( "{$child_theme_dir}/{$file_path}.php" );
		} else {
			require_once "{$child_theme_dir}/{$file_path}.php";
		}
	}
}
travel_ocean_include_files();
