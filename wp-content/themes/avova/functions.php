<?php

	add_action( 'after_setup_theme', 'avova_fn_setup', 50 );

	function avova_fn_setup(){

		// REGISTER THEME MENU
		if(function_exists('register_nav_menus')){
			register_nav_menus(array('main_menu' 	=> esc_html__('Main Menu','avova')));
			register_nav_menus(array('mobile_menu' 	=> esc_html__('Mobile Menu','avova')));
		}

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_action( 'wp_enqueue_scripts', 'avova_fn_scripts', 100 ); 
		add_action( 'wp_enqueue_scripts', 'avova_fn_styles', 100 );
		add_action( 'wp_enqueue_scripts', 'avova_fn_inline_styles', 150 );
		add_action( 'admin_enqueue_scripts', 'avova_fn_admin_scripts' );

		// Actions
		add_action( 'tgmpa_register', 'avova_fn_register_required_plugins' );

		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 300, 300, true ); 								// Normal post thumbnails
		add_image_size( 'avova_fn_thumb-720-9999', 720, 9999, false);			
		add_image_size( 'avova_fn_thumb-1200-9999', 1200, 9999, false);			

		//Load Translation Text Domain
		load_theme_textdomain( 'avova', get_template_directory() . '/languages' );





		// Firing Title Tag Function
		avova_fn_theme_slug_setup();

		add_filter(	'widget_tag_cloud_args', 'avova_fn_tag_cloud_args');

		if ( ! isset( $content_width ) ) { $content_width = 1170; }

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'wp_list_comments' );

		add_editor_style() ;

		
		add_action( 'wp_ajax_nopriv_avova_fn_ajax_portfolio', 'avova_fn_ajax_portfolio' );
		add_action( 'wp_ajax_avova_fn_ajax_portfolio', 'avova_fn_ajax_portfolio' );
		
		
		// for ajax woocommerce
		add_action( 'wp_ajax_nopriv_avova_fn_remove_item_from_cart', 'avova_fn_remove_item_from_cart' );
		add_action( 'wp_ajax_avova_fn_remove_item_from_cart', 'avova_fn_remove_item_from_cart' );
		
		
		// CONSTANTS
		$my_theme 		= wp_get_theme( 'avova' );
		$version		= '1.0';
		if ( $my_theme->exists() ){
			$version 	= (string)$my_theme->get( 'Version' );
		}
		$version		= 'ver_'.$version;
		define('AVOVA_VERSION', $version);
		define('AVOVA_URI', get_template_directory_uri());
		define('AVOVA_JS', AVOVA_URI . '/assets/js/');
		define('AVOVA_CSS', AVOVA_URI . '/assets/css/');
		register_setting('avova__options', 'avova_dismiss_notice', array('default' => ''));
		
		
		
		function avova_plugins_admin_notice() {
			
			$list 				= '';
			$plugins 			= array();
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
			if(!is_plugin_active('avova-core/avova-core.php') && !is_plugin_active('avova-core-premium/avova-core.php')){
				$URL			= 'https://frenify.com/project/avova/';
				$element		= '<a href="'.esc_url($URL).'" target="_blank">'.esc_html__('Avova Core', 'avova').'</a>';
				array_push($plugins,$element);
			}
			if(!empty($plugins)){
				$list 	= '<strong>'; $separator = ', ';
				$count	= count($plugins);
				foreach($plugins as $key => $plugin){
					if(($count > 1) && ($key === ($count - 1))){
						$list 	= rtrim($list,$separator);
						$list .= ' and ';
					}	
					$list .= $plugin . $separator;
				}
				$list  = rtrim($list,$separator);
				$list .= '</strong>';
			}
			if($list != ''){
				$class = 'notice notice-warning avova-dismiss-notice is-dismissible';

				printf( '<div class="%1$s"><p>We recommend installing the following plugins: %2$s.<br /> Please download the plugins and install them.</p></div>', esc_attr( $class ), $list );

			}

		}
		
		if( get_option( 'avova_dismiss_notice' ) != true ) {
			add_action( 'admin_notices', 'avova_plugins_admin_notice' );
		}
		
		
		/* ------------------------------------------------------------------------ */
		/*  Inlcudes
		/* ------------------------------------------------------------------------ */
		include_once( get_template_directory().'/inc/avova_fn_functions.php'); 				// Custom Functions
		include_once( get_template_directory().'/inc/avova_fn_googlefonts.php'); 				// Google Fonts Init
		include_once( get_template_directory().'/inc/avova_fn_css.php'); 						// Inline CSS
		include_once( get_template_directory().'/inc/avova_fn_sidebars.php'); 					// Widget Area
		include_once( get_template_directory().'/inc/avova_fn_pagination.php'); 				// Pagination
		include_once( get_template_directory().'/config/woo/config.php'); 					// WooCommerce	

}







/* ----------------------------------------------------------------------------------- */
/*  ENQUEUE STYLES AND SCRIPTS
/* ----------------------------------------------------------------------------------- */
	function avova_fn_scripts() {
		wp_enqueue_script( 'avova-fn-woocommerce', AVOVA_URI.'/config/woo/assets/woocommerce.js', array('jquery'), AVOVA_VERSION, TRUE);
		wp_enqueue_script( 'avova-fn-init', AVOVA_JS . 'init.js', array('jquery'), AVOVA_VERSION, TRUE);
		wp_localize_script( 'avova-fn-init', 'fn_avova_object', array(
			'ajax' 		=> esc_url(admin_url( 'admin-ajax.php' )),
			'siteurl' 	=> esc_url(home_url())
		));
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	}
	
	function avova_fn_admin_scripts() {
		wp_enqueue_script( 'avova-fn-admin-js', AVOVA_JS . 'admin.js', array('jquery'), AVOVA_VERSION, FALSE);
		wp_localize_script( 'avova-fn-admin-js', 'fn_object', array(
            'ajax' 		=> esc_url(admin_url( 'admin-ajax.php' )), 
        ));
		wp_enqueue_style( 'avova-fn-fontello', AVOVA_CSS . 'fontello.css', array(), AVOVA_VERSION, 'all');
	}

	function avova_fn_styles(){
		wp_enqueue_style( 'avova-fn-font-url', avova_fn_font_url(), array(), null );
		wp_enqueue_style( 'fontello', AVOVA_CSS . 'fontello.css', array(), AVOVA_VERSION, 'all' );
		wp_enqueue_style( 'avova-fn-woocommerce', AVOVA_URI . '/config/woo/assets/woocommerce.css', array(), AVOVA_VERSION, 'all' );
		wp_enqueue_style( 'avova-fn-base', AVOVA_CSS . 'base.css', array(), AVOVA_VERSION, 'all' );
		wp_enqueue_style( 'avova-fn-skeleton', AVOVA_CSS . 'skeleton.css', array(), AVOVA_VERSION, 'all' );
		wp_enqueue_style( 'avova-fn-stylesheet', get_stylesheet_uri(), array(), AVOVA_VERSION, 'all' );
	}
	

	add_action( 'wp_ajax_avova_dismiss_notice', 'avova_dismiss_notice' );

	function avova_dismiss_notice() {
	  	update_option( 'avova_dismiss_notice', true );
	}




/* ----------------------------------------------------------------------------------- */
/*  Title tag: works WordPress v4.1 and above
/* ----------------------------------------------------------------------------------- */
	function avova_fn_theme_slug_setup() {
		add_theme_support( 'title-tag' );
	}
/* ----------------------------------------------------------------------------------- */
/*  Tagcloud widget
/* ----------------------------------------------------------------------------------- */
	
	function avova_fn_tag_cloud_args($args)
	{
		
		$my_args 	= array('smallest' => 14, 'largest' => 14, 'unit'=>'px', 'orderby'=>'count', 'order'=>'DESC' );
		$args 		= wp_parse_args( $args, $my_args );
		return $args;
	}

	/**
	 * Fix skip link focus in IE11.
	 *
	 * This does not enqueue the script because it is tiny and because it is only for IE11,
	 * thus it does not warrant having an entire dedicated blocking script being loaded.
	 *
	 * @link https://git.io/vWdr2
	 */
	function avova_fn_skip_link_focus_fix() {
		// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
		?>
		<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
		</script>
		<?php
	}
	add_action( 'wp_print_footer_scripts', 'avova_fn_skip_link_focus_fix' );

?>