<?php 
global $avova_fn_option;


$totop_fixed_switch 	= 'disable';
// fixed totop switch
if(isset($avova_fn_option['totop_fixed_switch'])){
	$totop_fixed_switch = $avova_fn_option['totop_fixed_switch'];
}
$totopScrollHeight 		= 400;
if(isset($avova_fn_option['totop_fixed_active_h'])){
	$totopScrollHeight 	= $avova_fn_option['totop_fixed_active_h'];
}


// magic cursor options
$magic_cursor 		= array();
if(isset($avova_fn_option['magic_cursor'])){
	$magic_cursor 	= $avova_fn_option['magic_cursor'];
}
$mcursor__count		= 0;
$mcursor__default 	= 'no';
$mcursor__link 		= 'no';
$mcursor__slider 	= 'no';
if(!empty($magic_cursor)){
	$mcursor__count = count($magic_cursor);
	foreach($magic_cursor as $key => $value) {
		if($value == 'default'){$mcursor__default 	= 'yes';}
		if($value == 'link'){$mcursor__link 		= 'yes';}
		if($value == 'slider'){$mcursor__slider 	= 'yes';}
	}
}
if(isset($_GET['remove_mcursor'])){
	$mcursor__count = 0;
}
if( !defined( 'AVOVA_PRO_CORE' ) ){
	$mcursor__count = 0;
}
$demo_mode 			= 'disable';
if(isset($avova_fn_option['demo_mode'])){
	$demo_mode 		= $avova_fn_option['demo_mode'];
}
?>


			</div>
			<!-- /PAGES -->

		</div>
		<!-- /CONTENT -->
		
	</div>
	
	<footer class="avova__footer">
		<?php 

			// call custom footer
			do_action('frenify_theme_footer');

			// call default footer
			echo wp_kses(frenify_theme_footer_markup(), 'post');
		?>
	</footer>
		
	<?php if($totop_fixed_switch == 'enable'){ ?>
	<a href="#" class="avova_fn_totop demo_<?php echo esc_attr($demo_mode);?>">
		<?php echo wp_kses(avova_fn_getSVG_theme('up-arrow','fn_first'), 'post'); ?>
		<?php echo wp_kses(avova_fn_getSVG_theme('up-arrow','fn_second'), 'post'); ?>
		<input type="hidden" value="<?php echo esc_attr($totopScrollHeight);?>" />
	</a>
	<?php } ?>
	
	
	<?php if($mcursor__count > 0){ ?>
	<div class="frenify-cursor cursor-outer" data-default="<?php echo esc_attr($mcursor__default);?>" data-link="<?php echo esc_attr($mcursor__link);?>" data-slider="<?php echo esc_attr($mcursor__slider);?>"><span class="fn-cursor"></span></div>
	<div class="frenify-cursor cursor-inner" data-default="<?php echo esc_attr($mcursor__default);?>" data-link="<?php echo esc_attr($mcursor__link);?>" data-slider="<?php echo esc_attr($mcursor__slider);?>"><span class="fn-cursor"><span class="fn-left"></span><span class="fn-right"></span></span></div>
	<?php } ?>
	
	
	<?php if($demo_mode == 'enable'){ ?>
	<!-- Fixed Buttons -->
	<a href="https://wordpress.org/themes/avova/" class="fn_fixed_btn dwnld" target="_blank">
		<span class="btn"><img src="<?php echo esc_url(get_template_directory_uri());?>/assets/img/download.png" alt="<?php echo esc_attr__('svg', 'avova');?>" /></span>
		<span class="tooltip"><?php echo esc_html__('Download Now', 'avova');?></span>
	</a>
	<a href="https://frenify.com/project/avova/#theme_pricing" class="fn_fixed_btn prchs" target="_blank">
		<span class="btn"><span><?php echo esc_html__('49', 'avova');?></span></span>
		<span class="tooltip"><?php echo esc_html__('Purchase PRO', 'avova');?></span>
	</a>
	<!-- /Fixed Buttons -->
	<?php } ?>
	
</div>
<!-- HTML ends here -->

<?php wp_footer(); ?>
</body>
</html>