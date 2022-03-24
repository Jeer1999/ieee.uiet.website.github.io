<?php
/**
 * This is the main file for the travel_ocean customizer.
 *
 * @package travel-ocean
 * @subpackage inc/customizer
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travel_ocean_create_customizer_panel' ) ) {

	/**
	 * Creates the required panels in theme customizer options.
	 *
	 * @param object $wp_customize WordPress customizer objects.
	 */
	function travel_ocean_create_customizer_panel( $wp_customize ) {
		$wp_customize->add_panel(
			'travel_ocean_settings',
			array(
				'title'    => esc_html__( 'Travel Ocean Settings', 'travel-ocean' ),
				'priority' => 300,
			)
		);
	}
	add_action( 'customize_register', 'travel_ocean_create_customizer_panel' );
}


if ( ! function_exists( 'travel_ocean_customizer_includes' ) ) {

	/**
	 * It loads all the files related to customizer.
	 * Hooked in init to fix the custom taxonomy issues of wp travel.
	 */
	function travel_ocean_customizer_includes() {

		$child_theme_dir  = TRAVEL_OCEAN_CHILD_DIR;
		$customizer_files = array(
			'custom-controls/slim-select/class-travel-ocean-customizer-slim-select-control',
			'helpers',
			'sanitization-functions',

			'core-options',

			'travel-ocean-settings/banner-slider',
			'travel-ocean-settings/trip-filter',
			'travel-ocean-settings/trip-destinations',
			'travel-ocean-settings/featured-trips',
			'travel-ocean-settings/trip-activities',
			'travel-ocean-settings/customer-reviews',
		);

		if ( count( $customizer_files ) > 0 ) {
			foreach ( $customizer_files as $customizer_file ) {
				require_once "{$child_theme_dir}/inc/customizer/{$customizer_file}.php";
			}
		}

	}
	add_action( 'init', 'travel_ocean_customizer_includes' );
}
