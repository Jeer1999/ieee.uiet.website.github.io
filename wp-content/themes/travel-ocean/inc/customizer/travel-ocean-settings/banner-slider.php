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

if ( ! function_exists( 'travel_ocean_customizer_settings_banner_slider' ) ) {

	/**
	 * Adds settings and options for the banner slider option.
	 *
	 * @param object $wp_customize WP customizer object.
	 */
	function travel_ocean_customizer_settings_banner_slider( $wp_customize ) {
		$panel_id   = 'travel_ocean_settings';
		$section_id = 'travel_ocean_customizer_settings_banner_slider';

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
				'type'              => 'travel_ocean_slim_select',
				'custom_control'    => 'Travel_Ocean_Customizer_Slim_Select_Control',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'tax_dropdown' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'tax_dropdown' ),
				'sanitize_callback' => 'travel_ocean_sanitize_select',
				'description'       => esc_html__( 'If no taxonomy is selected, It will display the trips slides randomly.', 'travel-ocean' ),
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_banner_slider';
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
				'type'              => 'travel_ocean_slim_select',
				'custom_control'    => 'Travel_Ocean_Customizer_Slim_Select_Control',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'category_term' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'category_term' ),
				'sanitize_callback' => 'travel_ocean_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'category' === $selected_tax ) && $enable_section;
				},
				'choices'           => travel_ocean_get_wp_travel_terms( 'category' ),
				'label'             => esc_html__( 'Select Category', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'travel_ocean_slim_select',
				'custom_control'    => 'Travel_Ocean_Customizer_Slim_Select_Control',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'travel_locations_term' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'travel_locations_term' ),
				'sanitize_callback' => 'travel_ocean_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'travel_locations' === $selected_tax ) && $enable_section;
				},
				'choices'           => travel_ocean_get_wp_travel_terms( 'travel_locations' ),
				'label'             => esc_html__( 'Select Destination', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'travel_ocean_slim_select',
				'custom_control'    => 'Travel_Ocean_Customizer_Slim_Select_Control',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'itinerary_types_term' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'itinerary_types_term' ),
				'sanitize_callback' => 'travel_ocean_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'itinerary_types' === $selected_tax ) && $enable_section;
				},
				'choices'           => travel_ocean_get_wp_travel_terms( 'itinerary_types' ),
				'label'             => esc_html__( 'Select Trip Types', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'travel_ocean_slim_select',
				'custom_control'    => 'Travel_Ocean_Customizer_Slim_Select_Control',
				'name'              => travel_ocean_customizer_get_name( $panel_id, $section_id, 'activity_term' ),
				'default'           => travel_ocean_get_customizer_defaults( $panel_id, $section_id, 'activity_term' ),
				'sanitize_callback' => 'travel_ocean_sanitize_select',
				'active_callback'   => function() {
					$panel_id     = 'travel_ocean_settings';
					$section_id   = 'travel_ocean_customizer_settings_banner_slider';
					$options      = get_theme_mod( 'travel_ocean_theme_options' );
					$enable_section = ! empty( $options[ $panel_id ][ $section_id ]['enable_section'] ) ? $options[ $panel_id ][ $section_id ]['enable_section'] : false;
					$selected_tax = ! empty( $options[ $panel_id ][ $section_id ]['tax_dropdown'] ) ? $options[ $panel_id ][ $section_id ]['tax_dropdown'] : false;
					return ( 'activity' === $selected_tax ) && $enable_section;
				},
				'choices'           => travel_ocean_get_wp_travel_terms( 'activity' ),
				'label'             => esc_html__( 'Select Trip Activity', 'travel-ocean' ),
				'section'           => $section_id,
			)
		);

	}
	add_action( 'customize_register', 'travel_ocean_customizer_settings_banner_slider' );
}
