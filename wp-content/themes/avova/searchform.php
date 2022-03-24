<div class="search2">
    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" >
        <input type="text"  value="<?php esc_attr_e('Search','avova');?>..." onblur="if(this.value=='') this.value=this.defaultValue;" onfocus="if(this.value==this.defaultValue) this.value='';" class="ft" name="s"/>
        
        <input type="submit" value="" class="fs">
        
		<a class="fn_search" href="#"><img class="avova_fn_svg" src="<?php echo esc_url(get_template_directory_uri());?>/assets/svg/search.svg" alt="<?php echo esc_attr__('svg', 'avova');?>" /></a>
    </form>
</div>