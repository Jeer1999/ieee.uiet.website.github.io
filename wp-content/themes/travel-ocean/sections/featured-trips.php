<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * For inner loops: @see ./itinerary-section-loops/featured-trips.php
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

$panel_id       = 'travel_ocean_settings';
$section_id     = 'travel_ocean_customizer_settings_featured_trips';
$enable_section = travel_ocean_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travel_ocean_get_theme_option( $panel_id, $section_id, 'title' );

$args = array(
	'post_type'      => 'itineraries',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'meta_query'     => array( // phpcs:ignore
		array(
			'key'     => 'wp_travel_featured',
			'value'   => 'yes',
			'compare' => '=',
		),
	),
);

$the_query = new WP_Query( $args );
?>

<div id="itinerary-featured-trips" class="travel-ocean-section">
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
				<div class="grid-slider">
				<?php
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						get_template_part( 'sections/loops/content', 'featured-trips' );
					}
				}
				?>
				</div><!-- .grid-slider -->

			</div><!-- .feature-detail -->

		</div><!-- .section-content -->

	</div><!-- .wrapper -->

</div><!-- #itinerary-featured-trips -->
<?php
wp_reset_postdata();
