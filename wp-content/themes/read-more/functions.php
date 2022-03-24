<?php
/**
 * Read More functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Acme Themes
 * @subpackage Read More
 */


/**
 *  Default Theme layout options
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array $read_more_theme_layout
 *
 */
if ( !function_exists('read_more_get_default_theme_options') ) :
    function read_more_get_default_theme_options() {

        $default_theme_options = array(
            /*header*/
            'read-more-enable-header-top'  => '',
            'read-more-header-top-enable-social'  => '',
            'read-more-header-top-enable-menu'  => '',
            'read-more-phone-number'  => '',
            'read-more-top-email'  => '',
            'read-more-header-top-enable-search'  => '',

            /*feature section options*/
            'read-more-slider-from-category'  => 0,
            'read-more-featured-slider-number'  => 2,
            'read-more-enable-feature'  => '',
            'read-more-featured-slider-read-more-text'  => __( 'Read More', 'read-more' ),

            /*feature blog section options*/
            'read-more-blog-feature-title'  => __( 'Featured', 'read-more' ),
            'read-more-blog-feature-from-category'  => 0,
            'read-more-enable-feature-blog'  => '',

            /*header options*/
            'read-more-header-id-display-opt' => 'title-and-tagline',
            'read-more-facebook-url'  => '',
            'read-more-twitter-url'  => '',
            'read-more-youtube-url'  => '',
            'read-more-google-plus-url'  => '',
            'read-more-enable-social'  => '',

            /*footer options*/
            'read-more-footer-copyright'  => __( '&copy; All right reserved 2016', 'read-more' ),

            /*layout/design options*/
            'read-more-hide-front-page-content'  => '',

            'read-more-single-sidebar-layout'  => 'right-sidebar',
            'read-more-front-page-sidebar-layout'  => 'right-sidebar',
            'read-more-archive-sidebar-layout'  => 'right-sidebar',

            'read-more-blog-archive-layout'  => 'full-image',
            'read-more-blog-archive-image-layout' => 'large',
            'read-more-blog-archive-read-more-text'  => __( 'Read More', 'read-more' ),
            'read-more-blog-index-title'  => __( 'Latest News', 'read-more' ),
            'read-more-excerpt-length'  => 40,

            'read-more-pagination-option'  => 'numeric',
            'read-more-ajax-show-more'    => __( 'Show More', 'read-more' ),
            'read-more-ajax-no-more'    => __( 'No More', 'read-more' ),

            'read-more-author-options'  => 'advanced',
            'read-more-primary-color'  => '#2196F3',
            'read-more-enable-sticky-sidebar'  => 1,
            'read-more-button-design'  => 'design-1',

            /*single post options*/
            'read-more-show-related'  => 1,
            'read-more-single-image-layout'  => 'full',

            /*theme options*/
            'read-more-search-placholder'  => __( 'Search', 'read-more' ),
            'read-more-show-breadcrumb'  => 0,

            /*woocommerce*/
            'read-more-wc-shop-archive-sidebar-layout'     => 'no-sidebar',
            'read-more-wc-product-column-number'           => 4,
            'read-more-wc-shop-archive-total-product'      => 16,
            'read-more-wc-single-product-sidebar-layout'   => 'no-sidebar',
        );

        return apply_filters( 'read_more_default_theme_options', $default_theme_options );
    }
endif;

/**
 *  Get theme options
 *
 * @since Read More 1.0.0
 *
 * @param null
 * @return array read_more_theme_options
 *
 */
if ( !function_exists('read_more_get_theme_options') ) :
    function read_more_get_theme_options() {

        $read_more_default_theme_options = read_more_get_default_theme_options();
        $read_more_get_theme_options = get_theme_mod( 'read_more_theme_options');
        if( is_array( $read_more_get_theme_options )){
            return array_merge( $read_more_default_theme_options ,$read_more_get_theme_options );
        }
        else{
            return $read_more_default_theme_options;
        }
    }
endif;

$read_more_saved_theme_options = read_more_get_theme_options();
$GLOBALS['read_more_customizer_all_values'] = $read_more_saved_theme_options;

/**
 * Require init.
 */
require trailingslashit( get_template_directory() ).'acmethemes/init.php';