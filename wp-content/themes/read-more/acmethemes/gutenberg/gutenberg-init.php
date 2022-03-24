<?php
if ( ! function_exists( 'read_more_gutenberg_setup' ) ) :
	/**
	 * Making theme gutenberg compatible
	 */
	function read_more_gutenberg_setup() {
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
	}
endif;
add_action( 'after_setup_theme', 'read_more_gutenberg_setup' );

function read_more_dynamic_editor_styles(){

    $read_more_customizer_all_values= read_more_get_theme_options();

	$custom_css = '';

	$custom_css .= "
            .edit-post-visual-editor, 
			.edit-post-visual-editor p {
               color: #666;
            }";

	$custom_css .= "
	        .wp-block .wp-block-heading h1, 
	        .wp-block .wp-block-heading h1 a,
	        .wp-block .wp-block-heading h2,
	        .wp-block .wp-block-heading h2 a,
	        .wp-block .wp-block-heading h3, 
	        .wp-block .wp-block-heading h3 a,
	        .wp-block .wp-block-heading h4, 
	        .wp-block .wp-block-heading h4 a,
	        .wp-block .wp-block-heading h5, 
	        .wp-block .wp-block-heading h5 a,
	        .wp-block .wp-block-heading h6,
	        .wp-block .wp-block-heading h6 a{
	            color: #3a3a3a;
	        }";

	if( isset($read_more_customizer_all_values['read-more-link-color'])){
        $read_more_link_color               = esc_attr( $read_more_customizer_all_values['read-more-link-color'] );
        $custom_css .= "
	        .wp-block a{
	            color: {$read_more_link_color};
	        }";
    }
	if( isset($read_more_customizer_all_values['read-more-link-hover-color'] )){
        $read_more_link_hover_color         = esc_attr( $read_more_customizer_all_values['read-more-link-hover-color'] );
        $custom_css .= "
	        .wp-block a:hover,
	        .wp-block a:active,
	        .wp-block a:focus{
	            color: {$read_more_link_hover_color};
	        }";
    }
	return wp_strip_all_tags( $custom_css );
}

/**
 * Enqueue block editor style
 */
function read_more_block_editor_styles() {
	wp_enqueue_style( 'read-more-googleapis', '//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i', array(), null );
	wp_enqueue_style( 'read-more-block-editor-styles', get_template_directory_uri() . '/acmethemes/gutenberg/gutenberg-edit.css', false, '1.0' );

	/**
	 * Styles from the customizer
	 */
	wp_add_inline_style( 'read-more-block-editor-styles', read_more_dynamic_editor_styles() );
}
add_action( 'enqueue_block_editor_assets', 'read_more_block_editor_styles',99 );

function read_more_gutenberg_scripts() {
	wp_enqueue_style( 'read-more-block-front-styles', get_template_directory_uri() . '/acmethemes/gutenberg/gutenberg-front.css', false, '1.0' );
	wp_style_add_data( 'read-more-block-front-styles', 'rtl', 'replace' );
}
add_action( 'wp_enqueue_scripts', 'read_more_gutenberg_scripts' );