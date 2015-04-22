<?php
/*
 * Template Name: Content Page
 */
?>


<?php
/**
 * 
 *
 * @since 2.0.0
 */
get_header(); ?>

	<div id="primary" class="c9" <?php mp_primary_attr(); ?> role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" class="content-spacing-right" <?php post_class(); ?>>
				<h1 class="entry-title"><?php the_title(); ?></h1>

			    <div class="entry-content">
				    <?php the_content( '' ); ?>
			    </div><!-- .entry-content -->

			    <?php get_template_part( 'content', 'footer' ); ?>
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php comments_template( '', true ); ?>
		<?php endwhile; // end of the loop. ?>

	</div><!-- #primary.c8 -->


<?php get_footer(); ?>