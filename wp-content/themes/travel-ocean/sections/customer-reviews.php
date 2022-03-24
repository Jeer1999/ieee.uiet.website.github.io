<?php
/**
 * This is a section file for the Customer Reviews section.
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

$panel_id   = 'travel_ocean_settings';
$section_id = 'travel_ocean_customizer_settings_customer_reviews';

$enable_section = travel_ocean_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travel_ocean_get_theme_option( $panel_id, $section_id, 'title' );

?>

<div id="itinerary-customer-reviews" class="travel-ocean-section">
	<div class="wrapper">

		<div class="section-header">
			<div class="section-header-content">
				<?php if ( $section_title ) { ?>
					<h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
				<?php } ?>
				<a class="button theme-button" href="<?php echo esc_url( get_post_type_archive_link( 'itineraries' ) ); ?>">
					<?php esc_html_e( 'View All', 'travel-ocean' ); ?>
				</a>
			</div>
		</div>

		<div class="section-content">

			<div class="feature-detail">
				<div class="slider">
					<?php get_template_part( 'sections/loops/content', 'customer-reviews' ); ?>
				</div>

			</div><!-- .feature-detail -->

		</div><!-- .section-content -->

	</div><!-- .wrapper -->

</div><!-- #itinerary-customer-reviews -->
