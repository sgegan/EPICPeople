<?php
/**
 * The Template for displaying all single posts.
 *
 * @since 1.0.0
 */
get_header(); ?>

	<div id="primary" <?php mp_primary_attr(); ?> role="main">
		<?php while ( have_posts() ) : the_post();
	    	global $mp_content_area;
	    	$mp_content_area = 'main';
	    	get_template_part( 'content', get_post_format() );
	    	?>

			<nav id="posts-pagination">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'magazine-premium' ); ?></h3>				
				<div class="next fr"><?php next_post_link( '%link', __( '%title &rarr;', 'magazine-premium' ) ); ?></div>
				<div class="previous fl"><?php previous_post_link( '%link', __( '&larr; %title', 'magazine-premium' ) ); ?></div>
			</nav><!-- #posts-pagination -->

			<?php
			if ( 'attachment' != get_post_type( get_the_ID() ) )
			     comments_template( '', true );
			?>

		<?php endwhile; // end of the loop. ?>
	</div><!-- #primary.c8 -->

<?php get_footer(); ?>