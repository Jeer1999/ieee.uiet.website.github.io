<?php
/**
 * This is a file provides the section for the frontpage.
 *
 * @package travel-ocean
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel_id       = 'travel_ocean_settings';
$section_id     = 'travel_ocean_customizer_settings_trip_destinations';
$enable_section = travel_ocean_get_theme_option( $panel_id, $section_id, 'enable_section' );

if ( ! $enable_section ) {
	return;
}

$section_title = travel_ocean_get_theme_option( $panel_id, $section_id, 'title' );
$taxonomy_name = travel_ocean_get_theme_option( $panel_id, $section_id, 'tax_dropdown' );
$number_items  = travel_ocean_get_theme_option( $panel_id, $section_id, 'number_of_items' );

$itinerary_terms = get_terms(
	array(
		'taxonomy'   => $taxonomy_name,
		'hide_empty' => false,
	)
);

?>

<div id="itinerary-trip-destinations" class="travel-ocean-section">

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

		<div class="section-content-wrapper ">

			<div class="grid-box">

				<?php
				if ( is_array( $itinerary_terms ) && count( $itinerary_terms ) > 0 ) {
					foreach ( $itinerary_terms as $current_index_key => $itinerary_term ) {

						if ( $current_index_key >= $number_items ) {
							break;
						}

						$term_id    = ! empty( $itinerary_term->term_id ) ? $itinerary_term->term_id : false;
						$term_name  = ! empty( $itinerary_term->name ) ? $itinerary_term->name : false;
						$post_count = ! empty( $itinerary_term->count ) ? $itinerary_term->count : 0;

						// Attachments.
						$thumbnail_id  = get_term_meta( $term_id, 'wp_travel_trip_type_image_id', true );
						$placeholder   = function_exists( 'wp_travel_get_post_placeholder_image_url' ) ? wp_travel_get_post_placeholder_image_url() : '';
						$thumbnail_url = wp_get_attachment_url( $thumbnail_id );
						$thumbnail_url = ! empty( $thumbnail_url ) ? $thumbnail_url : $placeholder;

						if ( 0 === $post_count ) {
							$post_count_string = __( 'No Trips Available', 'travel-ocean' );
						} elseif ( 1 === $post_count ) {
							$post_count_string = __( '1 Trip Available', 'travel-ocean' );
						} else {
							/* translators: %d is the total number of trips in a selected term */
							$post_count_string = sprintf( __( '%d Trips Available', 'travel-ocean' ), $post_count );
						}

						?>
						<div class="box-item">
							<figure>
								<div class="img-container">
									<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>">
										<img src="<?php echo esc_url( $thumbnail_url ); ?>">
									</a>
								</div>
								<figcaption class="figcaption">
									<div class="left">
										<h2>
											<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>">
												<?php echo esc_html( $term_name ); ?>
											</a>
										</h2>
										<?php if ( 'category' !== $taxonomy_name ) { ?>
											<span> <i class="fas fa-suitcase-rolling"></i> <?php echo esc_html( $post_count_string ); ?> </span>
										<?php } ?>
									</div>
									<div class="button-item right">
										<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>" class="button theme-button"><?php esc_html_e( 'View', 'travel-ocean' ); ?></a>
									</div>
								</figcaption>
							</figure>
						</div>
						<?php
					}
				}
				?>

			</div> <!-- .grid-box -->

		</div> <!-- .section-content-wrapper -->

	</div> <!-- .wrapper -->

</div> <!-- #itinerary-trip-destinations -->
