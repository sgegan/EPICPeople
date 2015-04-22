<?php
/**
 * The template for displaying posts in the Video post format.
 *
 * @since 2.0.2
 */
global $mp_afp_columns;
$class = mp_home_page_class( $mp_afp_columns );
$bavotasan_theme_options = mp_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	    <?php get_template_part( 'content', 'header' ); ?>

		<div class="entry-content">
			<?php the_content( __( $bavotasan_theme_options['read_more'], 'magazine-premium' ) );	?>
		</div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article><!-- #post -->