<?php
/**
 * The template for displaying Search Results pages.
 *
 * @since 2.0.0
 */
get_header(); ?>

	<section id="primary" <?php mp_primary_attr(); ?> role="main">
		<?php if ( have_posts() ) : ?>

			<h1 id="search-header" class="page-title"><?php
				global $wp_query;
				printf( __( '%s search results for "%s"', 'magazine-premium' ), $wp_query->found_posts, get_search_query() );
				?></h1><!-- #search-header -->

			<?php
			while ( have_posts() ) : the_post();
		    	global $mp_content_area;
		    	$mp_content_area = 'main';
		    	get_template_part( 'content', get_post_format() );
			endwhile;

			mp_pagination();
		else :
			get_template_part( 'content', 'none' );
		endif;
		?>
	</section><!-- #primary.c8 -->

<?php get_footer(); ?>