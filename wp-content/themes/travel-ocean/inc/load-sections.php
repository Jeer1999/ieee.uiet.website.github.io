<?php
/**
 * This files handles the hooks for the wp travel related sections
 * at frontpage or where necessary.
 *
 * @package travel-ocean
 * @subpackage /inc
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travel_ocean_frontpage_header_and_title' ) ) {

	/**
	 * Enable or disable the header title at frontpage.
	 *
	 * @see oceanwp/header.php
	 */
	function travel_ocean_frontpage_header_and_title() {
		$display_header = get_theme_mod( 'travel_ocean_display_frontpage_title', false );
		if ( $display_header && is_front_page() ) {
			add_filter( 'ocean_display_page_header', '__return_false' );
		}
	}
	add_action( 'ocean_page_header', 'travel_ocean_frontpage_header_and_title' );
}

if ( ! function_exists( 'travel_ocean_sections_before_content_wrap' ) ) {

	/**
	 * Hooks or loads the itinerary sections that needs be displayed as ful width in homepage.
	 *
	 * @see oceanwp/page.php
	 */
	function travel_ocean_sections_before_content_wrap() {

		if ( ! is_front_page() ) {
			return;
		}

		/**
		 * List your content section file names here.
		 */
		$sections = array(
			'banner-slider',
		);

		foreach ( $sections as $section ) {
			get_template_part( "sections/{$section}" );
		}
	}
	add_action( 'ocean_before_content_wrap', 'travel_ocean_sections_before_content_wrap' );
}

if ( ! function_exists( 'travel_ocean_load_sections_content' ) ) {

	/**
	 * Hooks or loads the itinerary sections that needs be displayed as content in homepage.
	 *
	 * @see oceanwp/page.php
	 */
	function travel_ocean_load_sections_content() {

		if ( ! is_front_page() ) {
			return;
		}

		/**
		 * List your content section file names here.
		 */
		$sections = array(
			'trip-filter',
			'trip-destinations',
			'featured-trips',
			'trip-activities',
			'customer-reviews',
		);

		foreach ( $sections as $section ) {
			get_template_part( "sections/{$section}" );
		}
	}
	add_action( 'ocean_before_content_inner', 'travel_ocean_load_sections_content', 10 );
}
