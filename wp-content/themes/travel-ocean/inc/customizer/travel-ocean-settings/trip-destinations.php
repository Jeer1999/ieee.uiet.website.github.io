<?php
/**
 * This file has the settings for the trip destinations section options.
 *
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'travel_ocean_customizer_settings_trip_destinations' ) ) {

	/**
	 * Adds settings and options for the trip destinations option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travel_ocean_customizer_settings_trip_destinations( $wp_customize ) {
		$panel_id   = 'travel_ocean_settings';
		$section_id = 'travel_ocean_customizer_settings_trip_destinations';

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

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'text',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'title' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'title' ),
				'sanitize_callback' => 'sanitize_text_field',
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_trip_destinations';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'label'             => esc_html__( 'Title', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'travel_ocean_slim_select',
				'custom_control'    => 'Travel_Ocean_Customizer_Slim_Select_Control',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'tax_dropdown' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'tax_dropdown' ),
				'sanitize_callback' => 'travel_ocean_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_trip_destinations';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					return $enable_section;
				},
				'choices'           => travel_ocean_get_wp_travel_taxonomies(),
				'label'             => esc_html__( 'Taxonomy', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'number',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'number_of_items' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'number_of_items' ),
				'sanitize_callback' => 'sanitize_text_field',
				'description'       => esc_html__( 'Enter the number of items to display. Maximum limit: 8 items', 'travel-ocean' ),
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_trip_destinations';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$tax_dropdown = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return $enable_section && 'none' !== $tax_dropdown;
				},
				'input_attrs'       => array(
					'min' => 1,
					'max' => 8,
				),
				'label'             => esc_html__( 'Number Of Items', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

	}
	add_action( 'customize_register', 'travel_ocean_customizer_settings_trip_destinations' );
}
