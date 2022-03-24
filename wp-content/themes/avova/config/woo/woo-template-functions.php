<?php

// disable core woo styles
function avova_fn_woo_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] ); // Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation
	return wp_kses_post($enqueue_styles);
}


function avova_fn_woocommerce_before_avova_fn_main_content(){
	
	global $post, $avova_fn_option;

	if(is_shop()) {
		$pageID = get_option('woocommerce_shop_page_id'); 
	} else {
		$pageID = get_the_ID();
	}
	
	
	$avova_fn_pagestyle 		= get_post_meta($pageID,'avova_fn_page_style', true);
	$avova_fn_pagetitle 		= get_post_meta($pageID,'avova_fn_page_title', true);
	$avova_fn_top_padding 		= get_post_meta($pageID,'avova_fn_page_padding_top', true);
	$avova_fn_bot_padding 		= get_post_meta($pageID,'avova_fn_page_padding_bottom', true);
	
	

	$avova_fn_page_spaces = 'style=';
	if($avova_fn_top_padding != ''){$avova_fn_page_spaces .= 'padding-top:'.$avova_fn_top_padding.'px;';}
	if($avova_fn_bot_padding != ''){$avova_fn_page_spaces .= 'padding-bottom:'.$avova_fn_bot_padding.'px;';}
	if($avova_fn_top_padding == '' && $avova_fn_bot_padding == ''){$avova_fn_page_spaces = '';}
	

	
	// content wrap
	echo '<section class="avova_fn_woo_wrap">';
	echo '<div class="avova_fn_all_pages_content">';
	// Title Bar
	if($avova_fn_pagetitle != 'disable' && !is_single()){
		
			echo '<div class="avova_fn_pagetitle">
					 <div class="fn-container">';
			

						echo '<div class="title_holder"><h3>';
							if(is_product()) {
								the_title();
							} else {
								woocommerce_page_title();
							}
						echo '</h3>';
			    		avova_fn_breadcrumbs();
						echo '</div>';
					echo '</div>';
					echo '<div class="fn_corner">
							<span class="fn_corner_a"></span>
							<span class="fn_corner_b"></span>
						</div>';
		echo '</div>';
		
	}
	
	$containerOpener = '<div class="fn-container">';
	
	// Content
	echo '<div class="avova_fn_all_pages avova_fn_woo">
				'.$containerOpener.'
					<div class="avova_fn_all_pages_inner">';
	// if full
	if($avova_fn_pagestyle != 'ws' && !is_single()){
		if(is_product_category()){
			
			
			if(isset($avova_fn_option)){
				if(isset($avova_fn_option['woo_category_product_sidebar']) && $avova_fn_option['woo_category_product_sidebar'] === 'enable'){
					echo '<div class="avova_fn_hassidebar">
							<div class="avova_fn_leftsidebar frenify_fn_sticky_sidebar"' .esc_attr($avova_fn_page_spaces).'>';
				}
			}
			
		}else{
			echo '<div class="avova_fn_without_sidebar_page">
					<div class="inner">';
		}
		
	}
	// if we have sidebar
	if(($avova_fn_pagestyle == 'ws') && !is_single()){
		echo '<div class="avova_fn_hassidebar">
					<div class="avova_fn_leftsidebar frenify_fn_sticky_sidebar"' .esc_attr($avova_fn_page_spaces).'>';
	}
	if(is_single()){
		echo '<div class="avova_fn_product_single">';
	}
}						

function avova_fn_woocommerce_after_avova_fn_main_content(){
	
	global $post, $avova_fn_option;
	if(is_shop()) {
		$pageID = get_option('woocommerce_shop_page_id'); 
	} else {
		$pageID = get_the_ID();
	}
	$avova_fn_top_padding 		= get_post_meta($pageID,'avova_fn_page_padding_top', true);
	$avova_fn_bot_padding 		= get_post_meta($pageID,'avova_fn_page_padding_bottom', true);
	
	

	$avova_fn_page_spaces = 'style=';
	if($avova_fn_top_padding != ''){$avova_fn_page_spaces .= 'padding-top:'.$avova_fn_top_padding.'px;';}
	if($avova_fn_bot_padding != ''){$avova_fn_page_spaces .= 'padding-bottom:'.$avova_fn_bot_padding.'px;';}
	if($avova_fn_top_padding == '' && $avova_fn_bot_padding == ''){$avova_fn_page_spaces = '';}

	if(is_shop()) {
		$pageID = get_option('woocommerce_shop_page_id'); 
	} else {
		$pageID = get_the_ID();
	}

	$avova_fn_pagestyle 			= get_post_meta($pageID,'avova_fn_page_style', true);
	
	if($avova_fn_pagestyle != 'ws' && !is_single()){
		if(is_product_category()){
			if(isset($avova_fn_option)){
				if(isset($avova_fn_option['woo_category_product_sidebar']) && $avova_fn_option['woo_category_product_sidebar'] === 'enable'){
					echo '</div>';
					echo '<div class="avova_fn_rightsidebar frenify_fn_sticky_sidebar" ' .esc_attr($avova_fn_page_spaces).'>';
					get_sidebar();
					echo '</div></div>';
				}
			}
			
		}else{
			echo '</div></div>'; // end full
		}
	}
	
	
	
	// if we have sidebar
	if(($avova_fn_pagestyle == 'ws') && !is_single()){
		echo '</div>';
		echo '<div class="avova_fn_rightsidebar frenify_fn_sticky_sidebar" ' .esc_attr($avova_fn_page_spaces).'>';
		get_sidebar();
		echo '</div></div>';
	}
	
	$containerCloser = '</div>';
	echo '</div>'.$containerCloser.'</div>'; // end content
	if(is_single()){
		echo '</div>';
	}
	echo '</div>'; 
	echo '</section>'; // end content wrapper
	
	
}


// PRODUCTS PER PAGE
function avova_fn_loop_shop_per_page()
{
	global $avova_fn_option;


	if(isset($avova_fn_option['woo_per_page']) == 1 && $avova_fn_option['woo_per_page']) {
		$per_page = $avova_fn_option['woo_per_page'];
	} else {
		$per_page = 12;
	}

	return esc_html($per_page);
}



function avova_fn_woocommerce_thumbnail()
{
	global $product, $avova_fn_option;
	if ($product->get_type() == 'bundle' ){
		$product = new WC_Product_Bundle($product->get_id());
	}
	$rating = wc_get_rating_html( $product->get_average_rating() );
	$onsale = $product->is_on_sale(); //on sale
	$permalink = get_permalink( $product->get_id() );
	
	$price = $product->get_price_html();
	$title = $product->get_title();

	$id = get_the_ID();
	
	if(isset($avova_fn_option['woo_product_img_grid'])){
		$productsGridType 	= $avova_fn_option['woo_product_img_grid'];
	}else{
		$productsGridType 	= 'square';
	}
	if($productsGridType 		== 'square'){
		$productThumb			= avova_fn_callback_thumbs('square');
	}else if($productsGridType 	== 'portrait'){
		$productThumb			= avova_fn_callback_thumbs(800,970);
	}else if($productsGridType 	== 'landscape'){
		$productThumb			= avova_fn_callback_thumbs(700,570);
	}
	
	echo "<div class='thumbnail_container'>";
		echo wp_kses_post($productThumb);
			echo '<div class="original_img" data-fn-bg-img="'.get_the_post_thumbnail_url($id,'avova_fn_thumb-800-800').'"></div>';
			if($product->get_type() == 'simple') echo "<span class='cart-loading'><i class='fn-icon-ok'></i></span>";
			avova_fn_add_cart_button();
			echo "<a href='".$permalink."' class='overlay'></a>";
			if($onsale == 1){ echo "<span class='onsale'>" .esc_html__('Sale', 'avova') ."</span>"; }
	echo "</div>";
}

// NEW ADD TO CART BUTTON
function avova_fn_add_cart_button()
{
	global $product;

	if ($product->get_type() == 'bundle' ){
		$product = new WC_Product_Bundle($product->get_id());
	}

	$extraClass  = "";

	ob_start();
	woocommerce_template_loop_add_to_cart();
	$output = ob_get_clean();

	if(!empty($output))
	{
		$pos = strpos($output, ">");
		
		if ($pos !== false) {
		    $output = substr_replace($output,"><i class='fn-icon-basket'></i> ", $pos , strlen(1));
		}
	}
	 
	if(empty($extraClass)) $output .= "";
	
	
	if($output) echo "<div class='avova_fn_cart_buttons $extraClass'>$output</div>";
}


function woo_custom_cart_button_text() {
        return '';
}





function avova_fn_shop_overview_extra_header_div()
{
	global $product;

	if ($product->get_type() == 'bundle' ){
		$product = new WC_Product_Bundle($product->get_id());
	}
	
	echo "<div class='title_wrap'><a class='' href='".get_permalink($product->get_id())."'>";
}


function avova_fn_close_div()
{
	echo "</a></div>";
}


function avova_fn_wrap_sorting()
{
	echo "<div class='avova_fn_wrap_sorting'>";
}
function avova_fn_wrap_sorting_end()
{
	echo "</div>";
}


function avova_fn_wrap_crumb()
{
	echo "<div class='avova_fn_wrap_crumb'>";
}
function avova_fn_wrap_crumb_end()
{
	echo "</div>";
}

function avova_fn_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '<span> &#47; </span>',
            'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
            'wrap_after'  => '</nav>',
            'before'      => '',
            'after'       => '',
            'home'        => esc_html__( 'Home', 'avova' ),
        );
}



function avova_fn_open_product_wrap()
{
	if(!is_single()){
		echo "<div class='fn-container'>";
	}
}

function avova_fn_close_product_wrap()
{
	if(!is_single()){
		echo "</div>";
	}
}



function avova_fn_open_image_div()
{
	echo "<div class='single-product-image-wrap'>";
}

function avova_fn_close_image_div()
{
	echo "</div>";
}




function avova_fn_open_summary_div()
{
	echo "<div class='single-product-summary-wrap'>";
}

function avova_fn_close_summary_div()
{
	echo "</div>";
}




function avova_fn_woocommerce_output_related_products()
{
	$output = "";
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
		'orderby'        => 'rand'
	);
	ob_start();
	woocommerce_related_products($defaults); 
	$content = ob_get_clean();
	if($content)
	{
		
		$output .= '<div class="clearfix"></div><div class="single_product_related_wrap">';
		$output .= $content;
		$output .= '</div>';
		echo wp_kses_post($output);
	}

}

// define the woocommerce_before_cart callback 
function avova_fn_action_woocommerce_before_cart( $wccm_before_checkout ) { 
    // make action magic happen here... 
	echo "<div class='avova_fn_cart_page'><div class='fn-container'>";
}
         

// define the woocommerce_after_cart callback 
function avova_fn_action_woocommerce_after_cart( $wccm_after_checkout ) { 
    // make action magic happen here... 
	echo '</div></div>';
}
         

function avova_fn_remove_woo_lightbox(){
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_script( 'prettyPhoto-init' );
}
if(!function_exists('avova_fn_woocommerce_post_thumbnail_description'))
{	
	function avova_fn_woocommerce_post_thumbnail_description($img, $post_id)
	{
		global $post, $woocommerce, $product;

		if(has_post_thumbnail())
		{
			$image_title = esc_attr(get_post_field('post_title', get_post_thumbnail_id()));
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
			$image  = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );
			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			return sprintf( '<a href="%s" class="woocommerce-main-image zoom" title="%s" >%s</a>', $image_link, $image_title, $image);
		}

		return wp_kses_post($img);
	}
}

if(!function_exists('avova_fn_woocommerce_gallery_thumbnail_description'))
{
	function avova_fn_woocommerce_gallery_thumbnail_description($img, $attachment_id )
	{
			$image_link = wp_get_attachment_url( $attachment_id );

			if(!$image_link) return wp_kses_post($img);

			$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_single' ) );
			$image_title = esc_attr(get_post_field('post_title', $attachment_id));

			$img = sprintf( '<a href="%s" class="zoom" title="%s" >%s</a>', $image_link, $image_title, $image );

		return wp_kses_post($img);
	}
}


function avova_fn_woocommerce_cart_dropdown()
{
	global $woocommerce;
	$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
	$link = $woocommerce->cart->get_cart_url();
	$count = $woocommerce->cart->cart_contents_count;


	
	$html = "";
	$html .= "<div class='cart-wrap' data-success='".__('was added to the cart', 'avova')."'><div class='cart-nav'>";
	$html .= 	"<a class='cart_link' href='".$link."'><span><i class='pe-7s-cart'></i> <span class='prod_count'>" .$count. "</span></span></a>";
	$html .= 	'<div class="dropdown_widget dropdown_widget_cart"><div class="widget_shopping_cart_content">';
	$html .= "</div></div><div class='cart-note'></div></div></div>";

	echo wp_kses_post($html);
}


function avova_fn_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
	ob_start(); ?>
    <span class='prod_count'><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span>
	<?php
	
	$fragments['span.prod_count'] = ob_get_clean();
	
	return wp_kses_post($fragments);
}




function avova_fn_woocommerce_show_product_images(){
	global $post, $product;
	
	$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
	$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
	$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
	$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
	$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . $placeholder,
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	) );
	
	
	echo '<div class="'.esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ).'" data-columns="'.esc_attr( $columns ).'" style="opacity: 0; transition: opacity .25s ease-in-out;">
		<figure class="woocommerce-product-gallery__wrapper frenify_woo_product_list">';

			$attributes = array(
				'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
				'data-src'                => isset($full_size_image[0]) ? $full_size_image[0]: '',
				'data-large_image'        => isset($full_size_image[0]) ? $full_size_image[0]: '',
				'data-large_image_width'  => isset($full_size_image[1]) ? $full_size_image[1]: '',
				'data-large_image_height' => isset($full_size_image[2]) ? $full_size_image[2]: '',
			);
			if ( has_post_thumbnail() ) {
				$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'woocommerce_thumbnail' ) . '" class="woocommerce-product-gallery__image main_image"><a href="' . esc_url( $full_size_image[0] ) . '">';
				$html .= get_the_post_thumbnail( $post->ID, $full_size_image[0], $attributes );
				$html .= '</a></div>';
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'avova' ) );
				$html .= '</div>';
			}
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
			echo avova_fn_woo_product_thumbs();
			
	
	echo '</figure></div>';
}

function avova_fn_woo_product_thumbs(){
	global $post, $product;
	
	
	$attachment_ids = $product->get_gallery_image_ids();
	if ( $attachment_ids && has_post_thumbnail() ) {
		echo '<div class="frenify_thumb_wrap"><ul>';
		foreach ( $attachment_ids as $attachment_id ) {
			$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
			$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'woocommerce_thumbnail' );
			$attributes      = array(
				'title'                   => get_post_field( 'post_title', $attachment_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
				'data-src'                => $full_size_image[0],
				'data-large_image'        => $full_size_image[0],
				'data-large_image_width'  => $full_size_image[1],
				'data-large_image_height' => $full_size_image[2],
			);
			$html  = '<li><div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
			$html .= wp_get_attachment_image( $attachment_id, 'avova_fn_thumb-300-300', false, $attributes );
			$html .= '</a></div></li>';
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
		}
		echo '</ul></div>';
	}
	
}