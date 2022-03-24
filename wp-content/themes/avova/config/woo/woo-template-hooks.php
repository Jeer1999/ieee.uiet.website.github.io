<?php

remove_action ( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action ('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);


// DEFAULT ACTIONS
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );			// Remove Deafult Rating
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 ); // Remove Deafult Sale


// CHANGE MAIN LAYOUT
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action( 'woocommerce_before_main_content', 'avova_fn_woocommerce_before_avova_fn_main_content' );
add_action( 'woocommerce_after_main_content', 'avova_fn_woocommerce_after_avova_fn_main_content' );

add_filter('loop_shop_per_page', 'avova_fn_loop_shop_per_page');

// Removes the default post image from shop overview pages and replaces it with this image
add_action( 'woocommerce_before_shop_loop_item_title', 'avova_fn_woocommerce_thumbnail', 10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

// REMOVE "ADD TO CART" TEXT FROM NEW BUTTON
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' );

// REMOVE DEAFULT "ADD TO CART" TEXT FROM PRUDUCTS ON SHOP PAGE
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

// wrap product titles and sale number on overview pages into an extra div for improved styling options
add_action( 'woocommerce_before_shop_loop_item_title', 'avova_fn_shop_overview_extra_header_div', 20);

add_action( 'woocommerce_after_shop_loop_item_title',  'avova_fn_close_div', 1000);

// WRAP SORTING
add_action( 'woocommerce_before_shop_loop',  'avova_fn_wrap_sorting', 10);
add_action( 'woocommerce_before_shop_loop',  'avova_fn_wrap_sorting_end', 30);

// WRAP BREADCRUMBS
add_action( 'woocommerce_before_main_content',  'avova_fn_wrap_crumb', 10);
add_action( 'woocommerce_before_shop_loop',  'avova_fn_wrap_crumb_end', 0);
add_action( 'woocommerce_before_single_product',  'avova_fn_wrap_crumb_end', 0);

// CHANGE BREADCRUMBS
add_filter( 'woocommerce_breadcrumb_defaults', 'avova_fn_woocommerce_breadcrumbs' );

// Single Page Changes
add_action( 'woocommerce_before_single_product_summary', 'avova_fn_open_product_wrap', 2);
add_action( 'woocommerce_after_single_product_summary',  'avova_fn_close_product_wrap', 10);

// Single Page Changes
add_action( 'woocommerce_before_single_product_summary', 'avova_fn_open_summary_div', 0);
add_action( 'woocommerce_after_single_product_summary',  'avova_fn_close_summary_div', 0);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 0 );
add_action( 'woocommerce_before_single_product_summary','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
add_action( 'woocommerce_after_single_product_summary', 'avova_fn_woocommerce_output_related_products', 20);

// add the action 
add_action( 'woocommerce_before_cart', 'avova_fn_action_woocommerce_before_cart', 10, 1 );

// add the action 
add_action( 'woocommerce_after_cart', 'avova_fn_action_woocommerce_after_cart', 10, 1 ); 

// DISABLE PRETTY PHOTO
add_action( 'wp_enqueue_scripts', 'avova_fn_remove_woo_lightbox', 99 );

// SHOPPING CART
add_action( 'avova_fn_header_cart', 'avova_fn_woocommerce_cart_dropdown', 10);

// Update number of items next to basket on nav
add_filter('add_to_cart_fragments', 'avova_fn_header_add_to_cart_fragment');


// ---------------------------------------------------------------------------------------------------------------
// Added date : Dec 06, 2017. For frenify profile
// ---------------------------------------------------------------------------------------------------------------
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
add_action( 'woocommerce_before_single_product_summary', 'avova_fn_woocommerce_show_product_images', 20 );


// Single Page Changes
add_action( 'woocommerce_before_single_product_summary', 'avova_fn_open_image_div', 2);
add_action( 'woocommerce_before_single_product_summary',  'avova_fn_close_image_div', 20);


