<?php
/**
 * This files handles the enqueuing of the necessary styles and scripts.
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

if ( ! function_exists( 'travel_ocean_enqueue_styles_and_scripts' ) ) {

	/**
	 * Enqueue the registered styles and scripts.
	 */
	function travel_ocean_enqueue_styles_and_scripts() {
		$parent_dir_uri  = TRAVEL_OCEAN_PARENT_DIR_URI;
		$parent_version  = TRAVEL_OCEAN_PARENT_VERSION;
		$child_version   = TRAVEL_OCEAN_CHILD_VERSION;
		$child_theme_uri = TRAVEL_OCEAN_CHILD_DIR_URI;
		$suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.' : '.min.';

		$args = array(
			'parent_dir_uri'  => $parent_dir_uri,
			'parent_version'  => $parent_version,
			'child_version'   => $child_version,
			'child_theme_uri' => $child_theme_uri,
			'suffix'          => $suffix,
		);

		travel_ocean_enqueue_styles( $args );

		travel_ocean_enqueue_scripts( $args );

	}
	add_action( 'wp_enqueue_scripts', 'travel_ocean_enqueue_styles_and_scripts' );
}

if ( ! function_exists( 'travel_ocean_enqueue_styles' ) ) {

	/**
	 * Enqueue all stylesheets.
	 *
	 * @param array $args Required arguments for theme.
	 */
	function travel_ocean_enqueue_styles( $args ) {
		$suffix          = ! empty( $args['suffix'] ) ? $args['suffix'] : '.min.';
		$child_version   = ! empty( $args['child_version'] ) ? $args['child_version'] : '1.0.0';
		$child_theme_uri = ! empty( $args['child_theme_uri'] ) ? $args['child_theme_uri'] : '1.0.0';

		wp_enqueue_style( 'travel-ocean-dancing-script-font', 'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap', array(), '1.0.0' );
		wp_enqueue_style( 'travel-ocean-slick', $child_theme_uri . "/assets/css/slick{$suffix}css", array(), '1.8.1', 'all' );
		wp_enqueue_style( 'travel-ocean-slick-theme', $child_theme_uri . "/assets/css/slick-theme{$suffix}css", array(), '1.8.1', 'all' );
		wp_enqueue_style( 'travel-ocean-main', $child_theme_uri . "/assets/css/main{$suffix}css", array( 'oceanwp-style' ), $child_version, 'all' );
		wp_enqueue_style( 'travel-ocean-style', get_stylesheet_uri(), array( 'oceanwp-style' ), $child_version, 'all' );
	}
}


if ( ! function_exists( 'travel_ocean_enqueue_scripts' ) ) {

	/**
	 * Enqueue all scripts.
	 *
	 * @param array $args Required arguments for theme.
	 */
	function travel_ocean_enqueue_scripts( $args ) {
		$suffix          = ! empty( $args['suffix'] ) ? $args['suffix'] : '.min.';
		$child_version   = ! empty( $args['child_version'] ) ? $args['child_version'] : '1.0.0';
		$child_theme_uri = ! empty( $args['child_theme_uri'] ) ? $args['child_theme_uri'] : '1.0.0';

		wp_enqueue_script( 'travel-ocean-slick', $child_theme_uri . "/assets/js/slick{$suffix}js", array( 'jquery' ), '1.8.1', true );
		wp_enqueue_script( 'travel-ocean-script', $child_theme_uri . "/assets/js/main{$suffix}js", array( 'jquery' ), $child_version, true );
	}
}

if ( ! function_exists( 'travel_ocean_dynamic_css' ) ) {

	/**
	 * Add css codes to head that are need to be dynamic according to the customizer settings.
	 */
	function travel_ocean_dynamic_css() {

		$btn_bg_color       = get_theme_mod( 'ocean_theme_button_bg', '#13aff0' );
		$btn_bg_color_hover = get_theme_mod( 'ocean_theme_button_hover_bg', '#0b7cac' );
		$btn_color          = get_theme_mod( 'ocean_theme_button_color', '#ffffff' );
		$btn_color_hover    = get_theme_mod( 'ocean_theme_button_hover_color', '#ffffff' );

		$padding_top    = get_theme_mod( 'ocean_theme_button_top_padding', '14' );
		$padding_right  = get_theme_mod( 'ocean_theme_button_right_padding', '20' );
		$padding_button = get_theme_mod( 'ocean_theme_button_bottom_padding', '14' );
		$padding_left   = get_theme_mod( 'ocean_theme_button_left_padding', '20' );
		?>
		<style id="travel-ocean-dynamic-css" type="text/css">

			h1,h2,h3,h4,h5,h6,#site-logo a.site-logo-text, .theme-heading,.widget-title,.oceanwp-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title {
				font-family: 'Dancing Script', cursive;
			}

			.btn, .wp-travel-explore a, .wp-travel .button, .wp-travel-update-cart-btn, .my-order .no-order a, button[type="submit"],
			.btn-wp-travel-filter,
			.add-to-cart-btn,
			.submit,
			#wp-travel-enquiry-submit,
			.wp-travel-booknow-btn,
			.open-all-link,
			.close-all-link,
			.update-cart,
			.wp-travel-book,
			#wp-travel-search,
			#wp-travel-filter-search-submit,
			.contact-title a,
			#wp-travel-tab-content-bookings .my-order .book-more a {
				padding: <?php echo sprintf( '%spx %spx %spx %spx', esc_attr( $padding_top ), esc_attr( $padding_right ), esc_attr( $padding_button ), esc_attr( $padding_left ) ); ?> ! important;
				color: <?php echo esc_attr( $btn_color ); ?> !important;
				background-color: <?php echo esc_attr( $btn_bg_color ); ?> !important;
			}
			.slick-prev, .slick-next {
				color: <?php echo esc_attr( $btn_color ); ?> !important;
				background-color: <?php echo esc_attr( $btn_bg_color ); ?> !important;
			}
			.slick-prev:focus, .slick-prev:hover,
			.slick-next:focus, .slick-next:hover {
				color: <?php echo esc_attr( $btn_color_hover ); ?> !important;
				background-color: <?php echo esc_attr( $btn_bg_color_hover ); ?> !important;
			}
		</style>
		<?php
	}
	add_action( 'wp_head', 'travel_ocean_dynamic_css' );
}
