<?php
/**
 * The template for displaying article footers
 *
 * @since 2.0.0
 */
global $mp_content_area;
if ( is_singular() && 'sidebar' != $mp_content_area ) : ?>
    <footer class="entry">
		<?php
	    edit_post_link( __( '(edit)', 'magazine-premium' ), '<p class="edit-link">', '</p>' );
		if ( is_single() ) {
			if ( get_the_author_meta( 'description' ) && is_multi_author() ) echo do_shortcode( '' );
	    	wp_link_pages( array( 'before' => '<p id="pages">' . __( 'Pages:', 'magazine-premium' ) ) );
			/*the_tags( '<p class="tags"><i class="icon-tags"></i> ' . __( 'Tags:', 'magazine-premium' ), ' ', '</p>' );*/
	    }
		?>
	</footer><!-- .entry -->
	<?php
endif;