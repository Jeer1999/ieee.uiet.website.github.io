<?php

/* ------------------------------------------------------------------------ */
/* Define Sidebars */
/* ------------------------------------------------------------------------ */

add_action( 'widgets_init', 'avova_fn_widgets_init', 1000 );

function avova_fn_widgets_init() {
	if (function_exists('register_sidebar')) {

		/* ------------------------------------------------------------------------ */
		/* Right Bar
		/* ------------------------------------------------------------------------ */

		register_sidebar(array(
			'name' 			=> esc_html__('Right Bar', 'avova'),
			'id'   			=> 'avova-right-bar',
			'description'   => esc_html__('This is widget for right popup bar.', 'avova'),
			'before_widget' => '<div id="%1$s" class="widget_block clearfix %2$s"><div>',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="wid-title"><span>',
			'after_title'   => '</span></div>'
		));

		/* ------------------------------------------------------------------------ */
		/* Main Sidebar
		/* ------------------------------------------------------------------------ */
		register_sidebar(array(
			'name' 			=> esc_html__('Main Sidebar', 'avova'),
			'id'   			=> 'main-sidebar',
			'description'   => esc_html__('These are widgets for the sidebar.', 'avova'),
			'before_widget' => '<div id="%1$s" class="widget_block clear %2$s"><div>',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="wid-title"><span>',
			'after_title'   => '</span></div>'
		));
	}
}

    
?>