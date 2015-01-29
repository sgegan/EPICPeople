<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @since 2.0.0
 */
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
get_header(); ?>

	<section id="primary" <?php mp_primary_attr(); ?> role="main">

		<?php if ( have_posts() ) : ?>

			<?php echo do_shortcode( '[author_info]' ); ?>

			<?php
			while ( have_posts() ) : the_post();
				global $mp_content_area;
		    	$mp_content_area = 'main';

		    	/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
		    	get_template_part( 'content', get_post_format() );
			endwhile;

			mp_pagination();
		else :
			get_template_part( 'content', 'none' );
		endif;
		?>
	</section><!-- #primary.c8 -->

<?php get_footer(); ?>