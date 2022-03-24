<!DOCTYPE html >
<html <?php language_attributes(); ?>>
<head>
<?php global $avova_fn_option, $post; ?>

<meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<?php wp_head(); ?>

</head>
<?php 
	
	$options				= avova_fn_header_info();
	$navigation_skin		= avova_fn_getNavSkin();
	$navigation_pos			= avova_fn_getNavPos();
	$main_skin				= $options[0];
	$mobile_autocollapse	= $options[1];
	$page_title				= $options[2];
	$bg__text_skin			= $options[3];
	$right_panel_skin		= $options[4];
	$search_panel_skin		= $options[5];
	$preloader_switcher		= $options[6];
	$preloader_text			= $options[7];
	$preloader_speed		= $options[8];
	$core_ready				= 'core_absent';
	if(isset($avova_fn_option)){
		$core_ready 		= 'core_ready';
	}
	$type_text				= esc_html__('Type something and hit enter to search', 'avova');
?>
<body <?php body_class();?>>
	<?php wp_body_open(); ?>
	
	
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'avova' ); ?></a>
	<?php if($preloader_switcher == 'enabled'){ ?>
	<div class="avova_fn_pageloader" data-speed="<?php echo esc_attr($preloader_speed);?>">
		<div class="fn_preloader">
			<?php echo wp_kses($preloader_text, 'post');?>
		</div>
	</div>
	<?php } ?>
	
	<div class="avova_fn_popupshare">
		<div class="share_box">
			<div class="share_header"></div>
			<div class="share_content">
				<div class="share_title"></div>
				<div class="share_list"><ul></ul></div>
				<div class="share_closer"><?php echo wp_kses(avova_fn_getSVG_theme('cancel'), 'post'); ?></div>
			</div>
		</div>
	</div>
	
	<!-- SEARCH POPUP -->
	<div class="avova_fn_searchpopup" data-skin="<?php echo esc_attr($search_panel_skin);?>">
		<a href="#" class="extra_closer"></a>
		<div class="search_inner">
			<div class="fn-container">
				<div class="search_box">
					<form action="<?php echo esc_url(home_url('/')); ?>" method="get" >
						<input type="text" placeholder="<?php echo esc_attr($type_text);?>" name="s" autocomplete="off" />
						<input type="submit" class="pe-7s-search" value="" />
						<a href="#"><?php echo wp_kses_post(avova_fn_getSVG_theme('search-new'));?></a>
					</form>
				</div>
			</div>
			<a class="search_closer" href="#">
				<span class="s_text"><?php esc_html_e('Close', 'avova');?></span>
				<span class="s_btn"></span>
			</a>
		</div>
	</div>
	<!-- /SEARCH POPUP -->

	<!-- HTML starts here -->
	<div class="avova-fn-wrapper <?php echo esc_attr($core_ready); ?>" data-mobile-autocollapse="<?php echo esc_attr($mobile_autocollapse); ?>" data-page-title="<?php echo esc_attr($page_title); ?>" data-skin="<?php echo esc_attr($navigation_skin);?>" data-pos="<?php echo esc_attr($navigation_pos);?>" data-text-skin="<?php echo esc_attr($bg__text_skin);?>" data-rp-skin="<?php echo esc_attr($right_panel_skin);?>" data-main-skin="<?php echo esc_attr($main_skin);?>">

		<div class="avova__wrapper">
		
		
			<!-- Header -->
			<?php 
				// call custom header
				do_action('frenify_theme_header');
				// call default header
				echo wp_kses(frenify_theme_header_markup(), 'post');
			?>
			<!-- /Header -->
			
			<?php get_template_part( 'inc/templates/template-right-bar' );?>


			<!-- Mobile Menu -->
			<?php get_template_part( 'inc/templates/template-mobile-header' );?>
			<!-- /Mobile Menu -->


			<!-- CONTENT -->
			<div class="avova_fn_content">

				<!-- PAGES -->
				<div class="avova_fn_pages" id="content">
				
				