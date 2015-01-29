<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @since 2.0.0
 */
global $mp_content_area, $mp_afp_columns;
$class = mp_home_page_class( $mp_afp_columns );
$bavotasan_theme_options = mp_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
	        <?php
			if( has_post_thumbnail() && ( ! is_single() || 'sidebar' == $mp_content_area ) ) {
				echo '<a href="' . get_permalink() . '">';
				the_post_thumbnail( 'large', array( 'class' => 'alignnone' ) );
				echo '</a>';
			} else {
				the_content( __( $bavotasan_theme_options['read_more'], 'magazine-premium' ) );
			}
			?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article>