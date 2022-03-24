<?php

function avova_fn_inline_styles() {
	
	global $avova_fn_option;
	
	
	
	wp_enqueue_style('avova_fn_inline', get_template_directory_uri().'/assets/css/inline.css', array(), '1.0', 'all');
	/************************** START styles **************************/
	$avova_fn_custom_css 		= "";
	
	
	
	/* Page Spacing */
	$margin_top 	= 100;
	$margin_bottom 	= 100;
	$margin 		= 0;

	if(function_exists('rwmb_meta')){
		if(isset(get_post_meta(get_the_ID())['avova_fn_page_margin_top'])){
			$margin_top = get_post_meta(get_the_ID(), 'avova_fn_page_margin_top', true);
		}
		if(isset(get_post_meta(get_the_ID())['avova_fn_page_margin_bottom'])){
			$margin_bottom = get_post_meta(get_the_ID(), 'avova_fn_page_margin_bottom', true);
		}
		$margin += (int)$margin_top + (int)$margin_bottom;
	}
	$avova_fn_custom_css .= ".avova_fn_pages .avova_fn_full_page_in{padding-top:{$margin_top}px;padding-bottom:{$margin_bottom}px;}";
	if($margin_top > 100){$margin_top = 100;}
	if($margin_bottom > 100){$margin_bottom = 100;}
	$avova_fn_custom_css .= "@media(max-width: 1040px){.avova_fn_pages .avova_fn_full_page_in{padding-top:{$margin_top}px;padding-bottom:{$margin_bottom}px;}}";
	
	
	// main skin
	$main__skin				= 'dark';
	if(isset($avova_fn_option['main__skin'])){
		$main__skin			= $avova_fn_option['main__skin'];
	}
	
	
	// colors
	$heading_h_color 		= '#304bbe';
	if(isset($avova_fn_option['heading_h_color'])){
		$heading_h_color 	= $avova_fn_option['heading_h_color'];
	}
	$triangle_color 		= 'rgba(48,75,190,0.05)';
	if(isset($avova_fn_option['triangle_color']['rgba'])){
		$triangle_color 	= $avova_fn_option['triangle_color']['rgba'];
	}
	$primary_color 			= '#304bbe';
	if(isset($avova_fn_option['primary_color'])){
		$primary_color 		= $avova_fn_option['primary_color'];
	}
	$avova_fn_custom_css .= "
		.fn_corner .fn_corner_b,
		.fn_corner .fn_corner_a{
			border-bottom-color: {$triangle_color};
		}
		.fn_corner[data-pos='left'] .fn_corner_a,
		.fn_corner[data-pos='left'] .fn_corner_b{
			border-left-color: {$triangle_color};
		}
		
		
		.avova_fn_comment h4.author a:hover,
		.woocommerce table.shop_table td.product-name a:hover,
		.avova_fn_cartbox .fn_cartbox_item_title > span a:hover,
		.woocommerce ul.products li.product a:hover .woocommerce-loop-product__title,
		.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		h1 > a:hover, h2 > a:hover, h3 > a:hover, h4 > a:hover, h5 > a:hover, h6 > a:hover{color: {$heading_h_color};}
		
		.avova-fn-wrapper blockquote,
		.avova-fn-wrapper code, .avova-fn-wrapper pre{
			border-left-color: {$primary_color};
		}

		.widget_block.widget_tag_cloud a:hover,
		.widget_block.widget_meta a:hover,
		.widget_search .search-wrapper span,
		.avova_fn_widget_about .about_img:before,
		.avova_fn_widget_about .about_img:after,
		.avova_fn_searchpopup .extra_closer:hover + div .s_btn,
		.avova_fn_searchpopup .search_closer.closed .s_btn,
		.avova_fn_searchpopup .search_closer:hover .s_btn,
		.avova_fn_pagelinks a:hover,
		.avova_fn_pagelinks .post-page-numbers.current,
		.blog_content .fn_narrow_container .wp-block-calendar table a,
		.wp-block-search .wp-block-search__button,
		.blog_content .fn_narrow_container .wp-block-tag-cloud a:hover,
		.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable,
		.avova_fn_pagination.fn_type_3 li a:hover,
		.avova_fn_pagination.fn_type_3 li.active > a,
		.avova_fn_pagination.fn_type_3 li.active > span,
		ul.avova_fn_main_nav ul.sub-menu a:after,
		ul.avova_fn_main_nav button,
		ul.avova_fn_main_nav > li > a span:after{
			background-color: {$primary_color};
		}
		
		.woocommerce .fn_cart-empty a.button,
		.has-text-color{
			color: {$primary_color} !important;
		}
		
		a.woocommerce-privacy-policy-link,
		a.woocommerce-review-link:hover,
		.woocommerce-account .woocommerce-MyAccount-navigation .is-active a,
		.woocommerce-account .woocommerce-MyAccount-navigation a:hover,
		.woocommerce-account .woocommerce-MyAccount-content p a,
		[data-text-skin=dark] .avova_fn_post_header .author_name a:hover,
		.avova_fn_comment p.logged-in-as a,
		.widget_nav_menu ul li a:hover,
		.pingback a,
		.elementor-text-editor a,
		.widget_block a:hover,
		.avova_fn_popupshare .share_list a:hover,
		.avova_fn_like_share .like_btn a.liked,
		.avova_fn_ajax_portfolio ul.posts_list li .title_holder h3 a:hover,
		.avova_fn_author_info .author_bottom ul li a:hover,
		.avova_fn_post_header .author_name a:hover,
		.wp-block-latest-posts.wp-block-latest-posts__list a:hover,
		a.wp-block-latest-comments__comment-link:hover,
		a.wp-block-latest-comments__comment-author:hover,
		ul.wp-block-archives a:hover,
		.comment-text a,
		.avova_fn_author_meta p a:hover,
		.avova_fn_breadcrumbs a:hover,
		.avova_fn_footer .avova_fn_social_list a:hover,
		.avova_fn_footer .footer_copy a:hover,
		.avova-fn-wrapper[data-rp-skin='light'] .avova_fn_right_panel .widget_block a:hover,
		.avova-fn-wrapper[data-rp-skin='light'] .avova_fn_popup_sidebar .wp-block-archives a:hover,
		.avova-fn-wrapper[data-rp-skin='light'] .avova_fn_popup_sidebar .widget_avova_custom_categories a:hover,
		.avova-fn-wrapper[data-rp-skin='light'] .avova_fn_popup_sidebar .widget_archive a:hover,
		.avova-fn-wrapper[data-rp-skin='light'] .avova_fn_popup_sidebar .widget_categories a:hover,
		.tagged_as a:hover, .posted_in a:hover,
		.woocommerce p.stars:hover a::before,
		.woocommerce p.stars.selected a:not(.active)::before,
		.woocommerce p.stars.selected a.active::before,
		.woocommerce .star-rating span::before,
		a.woocommerce-review-link,
		.blog_content div:not(.wp-block-archives) a:not(.wp-block-button__link),
		.blog_content a:not(.wp-block-button__link),
		.elementor-widget-text-editor p a,
		ul.avova_fn_main_nav ul.sub-menu li:hover > a{
			color: {$primary_color};
		}
		
		.wp-block-latest-posts a:hover, .wp-block-latest-comments__comment-link:hover, .wp-block-latest-comments__comment-author:hover, .wp-block-archives li:hover a{
			color: {$primary_color} !important;
		}

		.avova_fn_popupshare .share_list a:hover,
		.avova_fn_author_info .author_bottom ul li a:hover,
		.avova_fn_footer .avova_fn_social_list a:hover{
			border-bottom-color: {$primary_color};
		}
		
		[data-text-skin='dark'] .avova_fn_footer .footer_copy a:hover{
			color: {$primary_color};
		}
		
		
		[data-main-skin='light'] .avova_fn_author_info .author_bottom ul li a:hover,
		[data-main-skin='light'] .avova_fn_footer .avova_fn_social_list a:hover,
		[data-text-skin='dark'] .avova_fn_author_info .author_bottom ul li a:hover,
		[data-text-skin='dark'] .avova_fn_footer .avova_fn_social_list a:hover{
			color: {$primary_color};
			border-color: transparent;
			border-bottom-color: {$primary_color};
		}
		
		
		.avova_fn_ajax_portfolio ul.posts_list li .overlay{
			background-color: {$primary_color};
		}
		
		
		.woocommerce-cart table.cart td.actions .coupon .input-text#coupon_code{
			border-color: {$primary_color};
		}
	";	
	
	
	// Button Color
	$button_bg_color 		= '#304bbe';
	if(isset($avova_fn_option['button_bg_color'])){
		$button_bg_color 	= $avova_fn_option['button_bg_color'];
	}
	$button_text_color 		= '#fff';
	if(isset($avova_fn_option['button_text_color'])){
		$button_text_color 	= $avova_fn_option['button_text_color'];
	}
	$avova_fn_custom_css .= "
		.is-style-outline>.wp-block-button__link,
		.wp-block-button__link.is-style-outline{
			border-color: {$button_bg_color};
			color: #eee !important;
		}
		.wp-block-button__link,
		.avova-fn-wrapper .opt-in-hound-opt-in-form-wrapper .opt-in-hound-opt-in-form-button button{
			background-color: {$button_bg_color} !important;
			color: {$button_text_color} !important;
		}
		.wp-block-search .wp-block-search__button{
			color: {$button_text_color};
		}
		
		a.fn_cartbox_updater,
		.woocommerce a.button,
		.woocommerce-message a.button.wc-forward,
		.woocommerce button.button,
		.woocommerce div.product form.cart .button,
		.woocommerce #respond input#submit,
		.avova_fn_category_info a:hover,
		.avova_fn_portfolio_page .fn_ajax_more a,
		.avova_fn_comment input[type=submit],
		.avova_fn_404 .search_holder span,
		input[type='submit'],
		.emaillist input[type='submit'],
		.avova_fn_read a,
		.avova_fn_comment #cancel-comment-reply-link:hover,
		.avova_fn_comment .fn_reply a,
		.avova-fn-protected .container-custom input[type=submit],
		.woocommerce #respond input#submit:hover,
		.woocommerce a.button:hover,
		.woocommerce button.button:hover,
		.woocommerce input.button:hover,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce a.button.alt:hover,
		.woocommerce button.button.alt:hover,
		.woocommerce input.button.alt:hover,
		.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
		.woocommerce #respond input#submit.alt,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt, .woocommerce input.button.alt,
		.avova_fn_cartbox .fn_cartbox_empty a,
		.avova_fn_cartbox .fn_cartbox_links a,
		.fn_contact input[type=submit]{
			background-color: {$button_bg_color};
			color: {$button_text_color};
			font-family: 'Heebo';
			font-weight: 500;
			border-radius: 4px;
		}
		.avova_fn_category_info a:hover{
			border-color: {$button_bg_color};
		}
		.avova_fn_comment .fn_reply .avova_fn_svg{
			color: {$button_text_color};
		}
		.avova_fn_read a .arrow:after{
			border-color: {$button_text_color};
		}
		.avova_fn_widget_subscribers a{
			background-color: {$button_bg_color};
			color: {$button_text_color};
		}
		.avova_fn_pagination.fn_type_3 li a:hover,
		.avova_fn_pagination.fn_type_3 li.active > a,
		.avova_fn_pagination.fn_type_3 li.active > span{
			color: {$button_text_color};
		}
		.avova_fn_pagination.fn_type_3 li.next a:hover span:after,
		.avova_fn_pagination.fn_type_3 li.next a:hover span:before,
		.avova_fn_pagination.fn_type_3 li.prev a:hover span:after,
		.avova_fn_pagination.fn_type_3 li.prev a:hover span:before,
		.avova_fn_pagination.fn_type_3 li.next a:hover span,
		.avova_fn_pagination.fn_type_3 li.prev a:hover span,
		.avova_fn_header .fn_trigger .ham_progress:after,
		.avova_fn_header .hamburger .hamburger-inner::before, .avova_fn_header .hamburger .hamburger-inner::after, .avova_fn_header .hamburger .hamburger-inner{
			background-color: {$button_text_color};
		}
		.avova_fn_footer .footer_right_totop .fn_icon{
			background-color: {$button_bg_color};
			color: {$button_text_color};
		}
	";
	
	// Magic Cursor
	$mcursor_color 		= '#fff';
	if(isset($avova_fn_option['mcursor_color'])){
		$mcursor_color 	= $avova_fn_option['mcursor_color'];
	}
	$mcursor_5 			= avova_fn_hex2rgba($mcursor_color,0.5);
	$mcursor_1	 		= avova_fn_hex2rgba($mcursor_color,0.1);
	$avova_fn_custom_css .= "
		.cursor-inner.cursor-slider.cursor-hover span:after,
		.cursor-inner.cursor-slider.cursor-hover span:before{
			background-color: {$mcursor_color};
		}
		.cursor-outer .fn-cursor,.cursor-inner.cursor-slider:not(.cursor-hover) .fn-cursor{
			border-color: {$mcursor_5};
		}
		.cursor-inner .fn-cursor,.cursor-inner .fn-left:before,.cursor-inner .fn-left:after,.cursor-inner .fn-right:before,.cursor-inner .fn-right:after{
			background-color: {$mcursor_5};
		}
		.cursor-inner.cursor-hover .fn-cursor{
			background-color: {$mcursor_1};
		}
	";
	
	
	// main color with opacity
	$p__01 	= avova_fn_hex2rgba($primary_color,0.1);
	$p__002 = avova_fn_hex2rgba($primary_color,0.02);
	$avova_fn_custom_css .= "
		ul.avova_fn_postlist .item.sticky{
			border-color: {$p__01};
    		background-color: {$p__002};
		}
	";
	
	
	//*************************************************************************//
	//**************************** Page Background ****************************//
	//*************************************************************************//
	
	// background pattern
	if(isset($avova_fn_option['bg__pattern_switcher'])){
		$bg__pattern_switcher 		= $avova_fn_option['bg__pattern_switcher'];
		if($bg__pattern_switcher == 'enabled'){
			if(isset($avova_fn_option['bg__pattern_list'])){
				$bg__pattern_list 		= $avova_fn_option['bg__pattern_list'];
				if($bg__pattern_list == 'custom'){
					if(isset($avova_fn_option['bg__custom_pattern']['url']) && $avova_fn_option['bg__custom_pattern']['url'] != ''){
						$bg__pattern 	= $avova_fn_option['bg__custom_pattern']['url'];
					}
				}else{
					$bg__pattern 		= get_template_directory_uri().'/assets/patterns/'.$bg__pattern_list.'.png';
				}
				if($bg__pattern !== ''){
					$avova_fn_custom_css .= '
						.avova__wrapper:before{
							content: "";
							position: absolute;
							top: 0;
							left: 0;
							right: 0;
							bottom: 0;
							background-repeat: repeat;
							z-index: -1;
							background-image: url('.$bg__pattern.');
						}
					';
				}
			}
		}
	}
	$bg__pattern_opacity = 0.1;
	if(isset($avova_fn_option['bg__pattern_opacity'])){
		$bg__pattern_opacity = $avova_fn_option['bg__pattern_opacity'];
	}
	$avova_fn_custom_css .= '
		.avova__wrapper:before{
			opacity: '.$bg__pattern_opacity.';
		}
	';
	$bg__color_opacity = 1;
	if(isset($avova_fn_option['bg__color_opacity'])){
		$bg__color_opacity = $avova_fn_option['bg__color_opacity'];
	}
	$avova_fn_custom_css .= '
		.avova__wrapper:after{
			opacity: '.$bg__color_opacity.';
		}
	';
	
	
	/* Page Preloader */
	$preloader__bgcolor 		= '#000';
	$preloader__textcolor 		= '#fff';
	if(isset($avova_fn_option['preloader__bgcolor'])){
		$preloader__bgcolor	 	= $avova_fn_option['preloader__bgcolor'];
	}
	if(isset($avova_fn_option['preloader__textcolor'])){
		$preloader__textcolor 	= $avova_fn_option['preloader__textcolor'];
	}
	$avova_fn_custom_css .= '
		.avova_fn_pageloader{background-color: '.$preloader__bgcolor.';}
		@keyframes avova-preloader-animation{
			0% {
				text-shadow: '.$preloader__textcolor.' 0 0 0;
			}

			90%, 100% {
				text-shadow: '.$preloader__bgcolor.' 0 0 19px;
			}
		}
	';
	
	$preloader__m_typography_ff 	= 'Heebo';
	$preloader__m_typography_fs 	= '50px';
	$preloader__m_typography_fw 	= '700';
	$preloader__m_typography_tt 	= 'uppercase';
	$preloader__m_typography_lh 	= '60px';
	if(isset($avova_fn_option['preloader__m_typography'])){
		$preloader__m_typography_ff = $avova_fn_option['preloader__m_typography']['font-family'];
		$preloader__m_typography_fs = $avova_fn_option['preloader__m_typography']['font-size'];
		$preloader__m_typography_fw = $avova_fn_option['preloader__m_typography']['font-weight'];
		$preloader__m_typography_tt = $avova_fn_option['preloader__m_typography']['text-transform'];
		$preloader__m_typography_lh = $avova_fn_option['preloader__m_typography']['line-height'];
	}
	$avova_fn_custom_css .= '
		@media(max-width: 768px){
			.avova_fn_pageloader .fn_item{
				font-family: '.$preloader__m_typography_ff.' !important;
				font-size: '.$preloader__m_typography_fs.' !important;
				font-weight: '.$preloader__m_typography_fw.' !important;
				text-transform: '.$preloader__m_typography_tt.' !important;
				line-height: '.$preloader__m_typography_lh.' !important;
			}
		}
	';
	
	/****************************** END styles *****************************/
	if(isset($avova_fn_option['custom_css'])){
		$avova_fn_custom_css .= "{$avova_fn_option['custom_css']}";	
	}
	
	// since v1.0.3
	$page_title_bg_color = '#0f0d10';
	$bg__color = '#0b0a0c';
	$heading_color = '#eeeeee';
	$body_color = '#aaaaaa';
	$footer_bg_color = '#0f0d10';
	if($main__skin == 'light'){
		$page_title_bg_color = '#ffffff';
		$bg__color = '#ffffff';
		$heading_color = '#0b0a0c';
		$body_color = '#888888';
		$footer_bg_color = '#fff';
	}
	
	if(isset($avova_fn_option['page_title_bg_color_'.$main__skin])){
		$page_title_bg_color = $avova_fn_option['page_title_bg_color_'.$main__skin];
	}
	if(isset($avova_fn_option['bg__color_'.$main__skin])){
		$bg__color = $avova_fn_option['bg__color_'.$main__skin];
	}
	if(isset($avova_fn_option['heading_color_'.$main__skin])){
		$heading_color = $avova_fn_option['heading_color_'.$main__skin];
	}
	if(isset($avova_fn_option['body_color_'.$main__skin])){
		$body_color = $avova_fn_option['body_color_'.$main__skin];
	}
	if(isset($avova_fn_option['footer_bg_color_'.$main__skin])){
		$footer_bg_color = $avova_fn_option['footer_bg_color_'.$main__skin];
	}
	
	$avova_fn_custom_css .= "
		.wp-block-archives a,
		.widget_avova_custom_categories a,
		.widget_archive a,
		.widget_categories a,
		body,
		.avova__wrapper:after{
			background-color: {$bg__color};
		}
		.avova_fn_pagetitle{background-color: {$page_title_bg_color};}
		
		
		.comment-reply-title,
		.woocommerce-account .woocommerce-MyAccount-navigation a,
		div.product .product_title,
		ul.products li.product .woocommerce-loop-category__title,
		ul.products li.product .woocommerce-loop-product__title,
		ul.products li.product h3,
		.woocommerce ul.products li.product .woocommerce-loop-category__title,
		.woocommerce ul.products li.product .woocommerce-loop-product__title,
		.woocommerce ul.products li.product h3,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a,
		.woocommerce div.product .product_title,
		.avova_fn_cartbox .fn_cartbox_subtotal span,
		.avova_fn_cartbox .fn_cartbox_item_title > span a,
		.woocommerce table.shop_table td.product-name a,
		.comment-text a,
		.wp-block-group__inner-container > h2, .wid-title span,
		.avova_fn_comment h3.comment-title-count,
		h1, h2, h3, h4, h5, h6, h1 > a, h2 > a, h3 > a, h4 > a, h5 > a, h6 > a{color: {$heading_color};}
		
		.avova_fn_comment p.logged-in-as a,
		.widget_block a,
		body,
		.avova_fn_comment h3.comment-reply-title,
		.avova_fn_comment p.comment-form-cookies-consent label,
		.avova_fn_footer .footer_copy a,
		.avova_fn_footer .footer_copy p{
			color: {$body_color};
		}
		
		.avova_fn_footer{background-color: {$footer_bg_color};}
	";
	
	$footer_fixed = 'disable';
	if(isset($avova_fn_option['footer_fixed'])){
		$footer_fixed = $avova_fn_option['footer_fixed'];
	}
	
	if( defined( 'AVOVA_PRO_CORE' ) ){
		if($footer_fixed == 'enable'){
			$avova_fn_custom_css .= "
				.avova__footer{
					position: -webkit-sticky;
					position: sticky;
					bottom: 0;
					overflow: hidden;
					padding-top: 20px;
					z-index: 0;
				}
				.avova__wrapper{
					z-index: 2;
				}
			";
		}
	}
	wp_add_inline_style( 'avova_fn_inline', $avova_fn_custom_css );

			
}

?>