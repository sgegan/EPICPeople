<?php
/**
 * The template for displaying posts in the Status post format
 *
 * @since 1.0.0
 */
global $mp_content_area, $mp_afp_columns;
$class = mp_home_page_class( $mp_afp_columns );
$bavotasan_theme_options = mp_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
		<header>
			<h3 class="post-format"><i class="icon-plus-sign-alt"></i><?php _e( 'Status', 'magazine-premium' ); ?></h3>
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
			<h1 class="author"><?php the_author(); ?></h1>
		</header>

		<div class="entry-content">
			<time class="published updated" datetime="<?php echo get_the_date( 'Y-m-d' ) . 'T' . get_the_time( 'H:i' ) . 'Z'; ?>">
				<?php printf( __( 'Posted on %1$s at %2$s', 'magazine-premium' ), get_the_date(), get_the_time() );	?>
			</time>

			<?php the_content( __( $bavotasan_theme_options['read_more'], 'magazine-premium' ) ); ?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
    </article>