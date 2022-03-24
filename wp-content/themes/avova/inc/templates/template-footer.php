<?php 
global $avova_fn_option, $post;
	
// top part
$text__html		= avova_fn_footer_text();
$social__html	= avova_fn_getSocialList('footer_');

$totop_footer_switch 	= 'enable';
if(isset($avova_fn_option['totop_footer_switch'])){
	$totop_footer_switch= $avova_fn_option['totop_footer_switch'];
}	
$footer_totop_pos 		= 'right';
if(isset($avova_fn_option['footer_totop_pos'])){
	$footer_totop_pos 	= $avova_fn_option['footer_totop_pos'];
}
if($totop_footer_switch == 'disable'){
	$footer_totop_pos 	= '';
}
?>
<!-- Footer starts here-->
<footer class="avova_fn_footer" data-pos="<?php echo esc_attr($footer_totop_pos);?>">
	<?php if($totop_footer_switch == 'enable' && $footer_totop_pos == 'top'){ ?>
	<div class="footer_totop">
		<a href="#">
			<?php echo wp_kses(avova_fn_getSVG_theme('up-arrow','fn_first'), 'post'); ?>
			<?php echo wp_kses(avova_fn_getSVG_theme('up-arrow','fn_second'), 'post'); ?>
		</a>
	</div>
	<?php } ?>
	<div class="fn-container">
		<div class="footer_content">

			<?php if($totop_footer_switch == 'enable' && $footer_totop_pos == 'right'){ ?>
			<div class="footer_left">
			<?php } ?>
				<!-- Footer content stars here -->
				<?php echo wp_kses($social__html, 'post'); ?>
				<?php echo wp_kses($text__html, 'post'); ?>						
				<!-- Footer content ends here -->
			</div>

			<?php if($totop_footer_switch == 'enable' && $footer_totop_pos == 'right'){ ?>	
			<div class="footer_right">
				<div class="footer_right_totop">
					<a href="#">
						<span class="fn_text">
							<?php 
								if(isset($avova_fn_option['totop_text'])){
									echo esc_html($avova_fn_option['totop_text']);
								}else{
									esc_html_e('To Top', 'avova');
								}
							?>
						</span>
						<span class="fn_icon">
							<?php echo wp_kses(avova_fn_getSVG_theme('up-arrow','fn_first'), 'post'); ?>
							<?php echo wp_kses(avova_fn_getSVG_theme('up-arrow','fn_second'), 'post'); ?>
						</span>
					</a>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
</footer>
<!-- Footer ends here-->