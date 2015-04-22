<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @since 2.0.0
 */
$bavotasan_theme_options = mp_theme_options();
get_header(); ?>

	<div id="primary" <?php mp_primary_attr(); ?> role="main">
		<?php
		global $bavotasan_slider;
		$bavotasan_slider->display_slider();

		$sticky = get_option( 'sticky_posts' );
		$featured = new WP_Query( array(
			'posts_per_page' => 1,
			'post__in'  => $sticky,
			'ignore_sticky_posts' => 1
		) );
		global $paged;
		if ( ! empty( $sticky[0] ) && is_home() && 2 > $paged ) {
			?>
		<div id="featured" class="row">
			<?php
			while ( $featured->have_posts() ) : $featured->the_post();
		    	global $mp_content_area;
		    	$mp_content_area = 'main';
				get_template_part( 'content', get_post_format() );
			endwhile;

			wp_reset_postdata();
			?>
		</div>
			<?php
		}

		$advanced_front_page = get_option( 'mp_advanced_front_page' );
		if ( ! empty( $advanced_front_page['upper'] ) ) {
			advanced_front_page( $advanced_front_page['upper'], 'upper' );
		} else {
			if ( have_posts() ) : ?>
				<div class="row">
				<?php
				while ( have_posts() ) : the_post();
					global $wp_query;
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var('paged') : 1;
					$grid = $bavotasan_theme_options['grid'];
					$posts_per_page = $bavotasan_theme_options['number'];
					$count = $wp_query->current_post;
					$total = $wp_query->post_count - 1;
					$border = ( 3 == $grid && 1 == $paged ) ? '<div class="c12 border"><span></span></div>' : '';

					if ( 1 < $posts_per_page ) {
						echo ( ( ( 2 == $grid || 3 == $grid ) && 1 == $count && 1 == $paged ) || ( 2 == $grid && 1 < $paged && 0 == $count ) ) ? '<!-- 2 cols --><div class="two-col-wrapper">' : '';

						echo ( ( ( 3 == $grid || 4 == $grid ) && 0 == $count && 1 < $paged ) || ( 1 == $paged && ( ( 3 == $grid && 3 == $count ) || ( 4 == $grid && 1 == $count ) ) ) ) ? $border . '<!-- 3 cols --><div class="three-col-wrapper">' : '';;
					}

			    	global $mp_content_area;
			    	$mp_content_area = 'main';
			    	get_template_part( 'content', get_post_format() );

					if ( 1 < $posts_per_page ) {
						echo ( ( 2 == $grid && $total == $count ) || ( 3 == $grid && 2 == $count && 1 == $paged ) ) ? '</div><!-- eof 2 cols -->' : '';
						echo ( ( 3 == $grid || 4 == $grid ) && $total == $count ) ? '</div><!-- eof 3 cols -->' : '';
					}

				endwhile;
				?>
				</div>
				<?php
				mp_pagination();

			else :
				get_template_part( 'content', 'none' );
			endif;
		}
		?>
	</div><!-- #primary.c8 -->

<?php get_footer(); ?>