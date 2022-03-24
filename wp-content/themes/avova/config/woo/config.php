<?php

function avova_fn_woocommerce_enabled()
{
	if ( class_exists( 'WooCommerce' ) ){ return true; }
	return false;
}


add_theme_support( 'woocommerce' );

//check if the plugin is enabled, otherwise stop the script
if(!avova_fn_woocommerce_enabled()) { return false; }


if ( ! class_exists( 'Frenify_WooCommerce' ) ) {
	
	class Frenify_WooCommerce {

		
		public function __construct() {
			add_action( 'init', array( $this, 'woo_setup' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'woo_scripts' ), 20 );
		}

		public function woo_setup() 
		{
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
			
			include_once(get_template_directory(). '/config/woo/woo-template-functions.php');
			include_once(get_template_directory(). '/config/woo/woo-template-hooks.php');
		}

		
		public function woo_scripts() 
		{
			wp_enqueue_style( 'avova-fn-woocommerce', AVOVA_URI . '/config/woo/assets/woocommerce.css', [], AVOVA_VERSION );
			wp_enqueue_script( 'avova-fn-woocommerce', AVOVA_URI. '/config/woo/assets/woocommerce.js', array('jquery'), AVOVA_VERSION, TRUE);
			wp_localize_script( 'avova-fn-woocommerce', 'fn_woo_object', array(
				'ajax' 		=> esc_url(admin_url( 'admin-ajax.php' )), 
			));
		}

	
	}

}

return new Frenify_WooCommerce();