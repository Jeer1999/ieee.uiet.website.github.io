<!-- Right Panel Starts -->
<?php if(is_active_sidebar( 'avova-right-bar' )){?>
<div class="avova_fn_right_panel">
	
	<a href="#" class="fn_closer">
		<img class="avova_fn_svg" src="<?php echo esc_url(get_template_directory_uri());?>/assets/svg/cancel.svg" alt="<?php echo esc_attr__('svg', 'avova');?>" />
	</a>
	<a href="#" class="extra_closer"></a>
	
	<div class="avova_fn_popup_sidebar">
		<div class="sidebar_wrapper">
				<?php dynamic_sidebar( 'avova-right-bar' ); ?>
		</div>
	</div>
	
</div>
<?php }?>
<!-- Right Panel Ends -->

<div class="avova_fn_hidden more_cats">
 	<div class="avova_fn_more_categories">
		<a href="#" data-more="<?php esc_attr_e('Show More','avova'); ?>" data-less="<?php esc_attr_e('Show Less','avova');?>">
			<span class="text"><?php esc_html_e('Show More','avova'); ?></span>
			<span class="fn_count"></span>
		</a>
	</div>
</div>