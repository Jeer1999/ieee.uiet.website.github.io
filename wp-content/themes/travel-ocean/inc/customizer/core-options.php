<?php
/**
 * This file has the settings for the wp customizer core or parent theme options.
 *
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'travel_ocean_create_other_core_options' ) ) {

	/**
	 * Adds other default or core options for the customizer and theme.
	 * for example: hide or display the frontpage static content
	 *
	 * @param object $wp_customize WordPress customizer objects.
	 */
	function travel_ocean_create_other_core_options( $wp_customize ) {

		/**
		 * Adds an checkbox to hide or display the page title at frontpage.
		 * Customizer > General Options > Page Title
		 */
		travel_ocean_register_option(
			$wp_customize,
			array(
				'type'              => 'checkbox',
				'priority'          => 8,
				'name'              => 'travel_ocean_display_frontpage_title',
				'default'           => false,
				'sanitize_callback' => 'travel_ocean_sanitize_checkbox',
				'label'             => esc_html__( 'Hide Page Title At Frontpage?', 'travel-ocean' ),
				'description'       => esc_html__( 'Hide or display the page title in static frontpage.', 'travel-ocean' ),
				'section'           => 'ocean_general_page_header', // Customizer > General Options > Page Title.
			)
		);

	}
	add_action( 'customize_register', 'travel_ocean_create_other_core_options' );
}
