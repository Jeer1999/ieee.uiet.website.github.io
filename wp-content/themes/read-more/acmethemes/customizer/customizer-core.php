<?php
/**
 * Featured Slider Number
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array $read_more_featured_slider_number
 *
 */
if ( !function_exists('read_more_featured_slider_number') ) :
    function read_more_featured_slider_number() {
        $read_more_featured_slider_number =  array(
            1 => __( '1', 'read-more' ),
            2 => __( '2', 'read-more' ),
            3 =>  __( '3', 'read-more' )
        );
        return apply_filters( 'read_more_featured_slider_number', $read_more_featured_slider_number );
    }
endif;

/**
 * Header logo/text display options alternative
 *
 * @since Read More 1.0.2
 *
 * @param null
 * @return array $read_more_header_id_display_opt
 *
 */
if ( !function_exists('read_more_header_id_display_opt') ) :
    function read_more_header_id_display_opt() {
        $read_more_header_id_display_opt =  array(
            'logo-only' => __( 'Logo Only ( First Select Logo Above )', 'read-more' ),
            'title-only' => __( 'Site Title Only', 'read-more' ),
            'title-and-tagline' =>  __( 'Site Title and Tagline', 'read-more' ),
            'disable' => __( 'Disable', 'read-more' )
        );
        return apply_filters( 'read_more_header_id_display_opt', $read_more_header_id_display_opt );
    }
endif;

/**
 * Sidebar layout options
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array $read_more_button_design
 *
 */
if ( !function_exists('read_more_button_design') ) :
    function read_more_button_design() {
        $read_more_button_design =  array(
            'normal'=> __( 'Normal', 'read-more' ),
            'design-1'=> __( 'Design 1' , 'read-more' )
        );
        return apply_filters( 'read_more_button_design', $read_more_button_design );
    }
endif;

/**
 * Sidebar layout options
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array $read_more_sidebar_layout
 *
 */
if ( !function_exists('read_more_sidebar_layout') ) :
    function read_more_sidebar_layout() {
        $read_more_sidebar_layout =  array(
	        'right-sidebar'=> __( 'Right Sidebar', 'read-more' ),
	        'left-sidebar'=> __( 'Left Sidebar' , 'read-more' ),
	        'both-sidebar'  => __( 'Both Sidebar' , 'read-more' ),
	        'middle-col'  => __( 'Middle Column' , 'read-more' ),
	        'no-sidebar'=> __( 'No Sidebar', 'read-more' )
        );
        return apply_filters( 'read_more_sidebar_layout', $read_more_sidebar_layout );
    }
endif;

/**
 * Blog layout options
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array $read_more_blog_layout
 *
 */
if ( !function_exists('read_more_blog_layout') ) :
    function read_more_blog_layout() {
        $read_more_blog_layout =  array(
            'full-image' => __( 'Full Image', 'read-more' ),
            'left-image' => __( 'Left Image', 'read-more' ),
            'no-image' => __( 'No Image', 'read-more' )
        );
        return apply_filters( 'read_more_blog_layout', $read_more_blog_layout );
    }
endif;

/**
 * Author Options
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array read_more_author_options
 *
 */
if ( !function_exists('read_more_author_options') ) :
    function read_more_author_options() {
        $read_more_author_options =  array(
            'default'  => __( 'Default', 'read-more' ),
            'advanced'  => __( 'Advanced', 'read-more' )
        );
        return apply_filters( 'read_more_author_options', $read_more_author_options );
    }
endif;

/**
 * Pagination Options
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array read_more_pagination_options
 *
 */
if ( !function_exists('read_more_pagination_options') ) :
	function read_more_pagination_options() {
		$read_more_pagination_options =  array(
			'default'  => __( 'Default', 'read-more' ),
			'numeric'  => __( 'Numeric', 'read-more' ),
			'ajax'  => __( 'Ajax Loading', 'read-more' ),
			'auto-ajax'  => __( 'Auto Loading', 'read-more' ),
		);
		return apply_filters( 'read_more_pagination_options', $read_more_pagination_options );
	}
endif;

/**
 * Blog layout options
 *
 * @since Read More 1.1.0
 *
 * @param null
 * @return array $read_more_get_image_sizes_options
 *
 */
if ( !function_exists('read_more_get_image_sizes_options') ) :
    function read_more_get_image_sizes_options( $add_disable = false ) {
        global $_wp_additional_image_sizes;
        $choices = array();
        if ( true == $add_disable ) {
            $choices['disable'] = __( 'No Image', 'read-more' );
        }
        foreach ( array( 'thumbnail', 'medium', 'large' ) as $key => $_size ) {
            $choices[ $_size ] = $_size . ' ('. get_option( $_size . '_size_w' ) . 'x' . get_option( $_size . '_size_h' ) . ')';
        }
        $choices['full'] = __( 'full (original)', 'read-more' );
        if ( ! empty( $_wp_additional_image_sizes ) && is_array( $_wp_additional_image_sizes ) ) {

            foreach ($_wp_additional_image_sizes as $key => $size ) {
                $choices[ $key ] = $key . ' ('. $size['width'] . 'x' . $size['height'] . ')';
            }
        }
        return apply_filters( 'read_more_get_image_sizes_options', $choices );
    }
endif;