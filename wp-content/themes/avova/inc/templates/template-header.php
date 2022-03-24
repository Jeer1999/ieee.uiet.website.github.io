<?php 
	global $avova_fn_option, $post;
	

	// get navigation skin
	$navigation_skin	= avova_fn_getNavSkin();

	if($navigation_skin == 'dark'){
		$default_logo 	= avova_fn_getLogo('dark');
	}else{
		$default_logo 	= avova_fn_getLogo('light');
	}
	$logo  = '<div class="fn_logo">';
		$logo .= $default_logo;
	$logo .= '</div>';



	if(has_nav_menu('main_menu')){
		$menu = wp_nav_menu( array('theme_location'  => 'main_menu','menu_class' => 'avova_fn_main_nav', 'echo' => false, 'link_before' => '<span class="link">', 'link_after' => '</span>') );
	}else{
		$menu = '<ul class="avova_fn_main_nav"><li><a href=""><span class="link">'.esc_html__('No menu assigned', 'avova').'</span></a></li></ul>';
	}
	

	$helper_counter		= 0;
	$search_switcher 	= 'enabled';
	$cart_switcher 		= 'enabled';
	$trigger_switcher 	= 'enabled';
	if(isset($avova_fn_option['search_switcher'])){$search_switcher = $avova_fn_option['search_switcher'];}
	if(isset($avova_fn_option['cart_switcher'])){$cart_switcher = $avova_fn_option['cart_switcher'];}
	if(isset($avova_fn_option['trigger_switcher'])){$trigger_switcher = $avova_fn_option['trigger_switcher'];}
	if($search_switcher == 'enabled'){$helper_counter++;}
	if($cart_switcher == 'enabled'){$helper_counter++;}
	if($trigger_switcher == 'enabled'){$helper_counter++;}
	
	
?>
<header class="avova_fn_header">
	<div class="fn-container">
		<div class="header_inner">

			<div class="header_logo">
				<?php echo wp_kses($logo, 'post'); ?>
			</div>

			<div class="header_nav_wrap">
				<div class="header_nav">
					<?php echo wp_kses($menu, 'post'); ?>
				</div>
			</div>
			
			<?php if($helper_counter > 0){ ?>
			<div class="header_helper">
			
				<?php if($search_switcher == 'enabled'){ ?>
				<a class="fn_finder" href="#">
					<img class="avova_fn_svg" src="<?php echo esc_url(get_template_directory_uri());?>/assets/svg/search-new.svg" alt="<?php echo esc_attr__('svg', 'avova');?>" />
				</a>
				<?php } ?>
				
				<?php if($cart_switcher == 'enabled'){ ?>
					<?php echo wp_kses(avova_fn_buy_button(),'post'); ?>
				<?php } ?>
				
				<?php if($trigger_switcher == 'enabled' && is_active_sidebar( 'avova-right-bar' )){ ?>
					<a class="fn_trigger" href="#">
						<div class="hamburger hamburger--collapse-r">
							<div class="hamburger-box">
								<div class="hamburger-inner"></div>
							</div>
						</div>
						<div class="ham_progress"></div>
					</a>
				<?php } ?>
				
				
			</div>
			<?php } ?>

		</div>
	</div>
</header>