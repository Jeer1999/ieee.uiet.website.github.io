<?php
/**
 * This file has the settings for the banner section options.
 *
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'WP_Travel' ) ) {
	return;
}

if ( ! function_exists( 'travel_ocean_customizer_settings_trip_filter' ) ) {

	/**
	 * Adds settings and options for the banner slider option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travel_ocean_customizer_settings_trip_filter( $wp_customize ) {
		$panel_id   = 'travel_ocean_settings';
		$section_id = 'travel_ocean_customizer_settings_trip_filter';

		// Add section.
		$wp_customize->add_section(
			$section_id,
			array(
				'title' => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'title' ),
				'panel' => $panel_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'checkbox',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'enable_section' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'enable_section' ),
				'sanitize_callback' => 'travel_ocean_sanitize_checkbox',
				'label'             => esc_html__( 'Enable Section?', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

	}
	add_action( 'customize_register', 'travel_ocean_customizer_settings_trip_filter' );
}
