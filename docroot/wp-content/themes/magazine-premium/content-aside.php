<?php
/**
 * The template for displaying posts in the Aside post format
 *
 * @since 1.0.0
 */
global $mp_content_area, $mp_afp_columns;
$class = mp_home_page_class( $mp_afp_columns );
$bavotasan_theme_options = mp_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
		<h3 class="post-format"><i class="icon-asterisk"></i><?php _e( 'Aside', 'magazine-premium' ); ?></h3>

	    <div class="entry-content">
		    <?php the_content( __( $bavotasan_theme_options['read_more'], 'magazine-premium' ) ); ?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article>