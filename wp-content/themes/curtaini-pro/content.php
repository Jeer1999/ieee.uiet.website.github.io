<?php
/**
 * @package Curtaini Pro
 */
?>
 <div class="Unicare-Article-Listing">
 <div class="Unicare-ContentStyle">     
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>         
		  <?php if( get_theme_mod( 'curtaini_pro_hide_postfeatured_image' ) == '') { ?> 
			 <?php if (has_post_thumbnail() ){ ?>
                <div class="BlogImgDiv <?php if( esc_attr( get_theme_mod( 'curtaini_pro_postimg_left30' )) ) { ?>imgLeft<?php } ?>">
                 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                </div>
             <?php } ?> 
          <?php } ?> 
       
        <header class="entry-header">
           <?php if ( 'post' == get_post_type() ) : ?>
                <div class="Unicare-BlogPostMeta">
                   <?php if( get_theme_mod( 'curtaini_pro_hide_blogdate' ) == '') { ?> 
                      <div class="post-date"> <i class="far fa-clock"></i>  <?php echo esc_html( get_the_date() ); ?></div><!-- post-date --> 
                    <?php } ?> 
                    
                    <?php if( get_theme_mod( 'curtaini_pro_hide_postcats' ) == '') { ?> 
                      <span class="blogpost_cat"> <i class="far fa-folder-open"></i> <?php the_category( __( ', ', 'curtaini-pro' ));?></span>
                   <?php } ?>                                                   
                </div><!-- .Unicare-BlogPostMeta -->
            <?php endif; ?>
            <h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>                           
                                
        </header><!-- .entry-header -->          
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">           
         <p>
            <?php $curtaini_pro_arg = get_theme_mod( 'curtaini_pro_postsfullcontent_options','Excerpt');
              if($curtaini_pro_arg == 'Content'){ ?>
                <?php the_content(); ?>
              <?php }
              if($curtaini_pro_arg == 'Excerpt'){ ?>
                <?php if(get_the_excerpt()) { ?>
                  <?php $excerpt = get_the_excerpt(); echo esc_html( curtaini_pro_string_limit_words( $excerpt, esc_attr(get_theme_mod('curtaini_pro_postexcerptrange','30')))); ?>
                <?php }?>
                
                 <?php
					$curtaini_pro_postmorebuttontext = get_theme_mod('curtaini_pro_postmorebuttontext');
					if( !empty($curtaini_pro_postmorebuttontext) ){ ?>
					<a class="morebutton" href="<?php the_permalink(); ?>"><?php echo esc_html($curtaini_pro_postmorebuttontext); ?></a>
                <?php } ?>                
              <?php }?>
           </p>
                    
        </div><!-- .entry-summary -->
        <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'curtaini-pro' ) ); ?>
            <?php
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'curtaini-pro' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-content -->
        <?php endif; ?>
        <div class="clear"></div>
    </div><!-- .Unicare-ContentStyle-->
    </article><!-- #post-## -->
</div>