<?php // Custom Comment template
function avova_fn_comment( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; 
	global $post;
	$icon = avova_fn_getSVG_theme('reply');
	
   	switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' : ?> <li class="post pingback"><div><p><?php esc_html_e( 'Pingback:', 'avova' ); ?> <?php esc_url(comment_author_link()); ?><?php edit_comment_link( esc_html__( 'Edit', 'avova' ), '<span class="edit-link">', '</span>' ); ?></p></div></li><?php
		break;
			
		default :

    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-avatar"><?php echo get_avatar( $comment, $size='80' ); ?></div>
            <div class="commment-text-wrap">
            	
                <div class="comment-data">
					<h4 class="author"><?php esc_url(comment_author_link()); ?></h4>
					<p class="time"><?php printf('<span>%3$s at %1$s</span>', get_comment_time('g:i a'), get_comment_ID(), get_comment_date('F j, Y') );?></p>
				</div>
                
                
                <div class="comment-text">
                	<?php if ($comment->comment_approved == '0') : ?>
                    <span class="waiting"><?php esc_html_e('Your comment is awaiting moderation', 'avova') ?></span>
                    <?php endif; ?>
                    <?php comment_text() ?>
                    <span class="fn_reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'link_text' => 'asdasd', 'before' => '<span class="comment-reply">'.$icon,'after' => '</span>')));  edit_comment_link(esc_html__('edit', 'avova'),'&nbsp;','');?>
                    </span>
                </div>
            </div>
        </div>
    
<?php }} ?>

<?php
// Do not delete these lines

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'avova'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments()) : ?>
	<div class="comment_list">
		<?php if(wp_count_comments() !== 0){?>
			<h3 class="comment-title-count"><?php comments_number( esc_html__( 'No Comment', 'avova' ), esc_html__( 'One Comment', 'avova' ), esc_html__( '% Comments', 'avova' ) );?> </h3>
		<?php }?>
		<ul class="commentlist">
			<?php wp_list_comments('type=all&callback=avova_fn_comment'); ?>
		</ul>
	</div>
    <?php
		// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="comment-navigation">
		<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'avova' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'avova' ) ); ?></div>
	</nav><!-- .comment-navigation -->
	<?php endif; // Check for comment navigation ?>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php esc_html_e('Comments are closed.', 'avova'); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php 
		
	$comment_form = array( 
		'fields' => apply_filters( 'comment_form_default_fields', array(
			'author' => '<div class="input-holder input-half input-author"><input class="com-text" id="author" name="author" placeholder="'.esc_attr__('Name', 'avova').'" type="text"  value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1" /></div>',
						
			'email'  => '<div class="input-holder input-half input-email"><input class="com-text" id="emailme" placeholder="'.esc_attr__('Email', 'avova').'" name="email" type="text"  value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" tabindex="2" /></div>',
			 )),
			
			'comment_form_logged_in' => '<div class="input-holder"></label><textarea placeholder="'.esc_attr__('Comment', 'avova').'" id="comment" name="comment" aria-required="true" rows="10"></textarea></div>',
			'comment_field' => '<div class="input-holder"></label><textarea placeholder="'.esc_attr__('Comment', 'avova').'" id="comment" name="comment" aria-required="true" rows="10"></textarea></div>',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'title_reply'=>'<span class="comment-title">'. esc_html__('Leave a reply', 'avova') .'</span>'
	);
	comment_form($comment_form, $post->ID);
?>