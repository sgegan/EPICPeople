<?php
/*
 * Template Name: About
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
			<article id="post-<?php the_ID(); ?>" class="" <?php post_class(); ?>>
				<div class="row"><h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="about-interior-links">
					
						<h5><a href="#history">History of EPIC</a></h5>
						<h5><a href="#people">People</a></h5>
						<h5><a href="#support">Support</a></h5>
					
				</div>
				</div>

			    <div class="entry-content">
				    <?php the_content( '' ); ?>
			    </div><!-- .entry-content -->

			    <?php get_template_part( 'content', 'footer' ); ?>
			</article><!-- #post-<?php the_ID(); ?> -->

			<?php comments_template( '', true ); ?>
		<?php endwhile; // end of the loop. ?>

	</div><!-- #primary.c8 -->


<?php get_footer(); ?>