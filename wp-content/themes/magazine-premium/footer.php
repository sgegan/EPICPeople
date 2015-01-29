<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main, .grid and #page div elements.
 *
 * @since 2.0.0
 */
$bavotasan_theme_options = mp_theme_options();

			/* Do not display sidebars if full width option selected on single
			   post/page templates */
			if ( ! is_mp_full_width() ) {
				if ( 5 != $bavotasan_theme_options['layout'] )
					get_sidebar();

				get_sidebar( 'second' );
			}
			?>
		</div><!-- .row -->

		<?php
		// Lower index section
		if ( is_home() )
			get_template_part( 'index', 'lower' );

		if ( ! empty( $bavotasan_theme_options['image_bar_display'] ) ) {
			?>
		<div id="image-bar" class="row">
			<div class="c12">
				<?php if ( get_cat_name( $bavotasan_theme_options['image_bar_category'] ) ) { ?>
				<h1 class="page-title"><?php echo get_cat_name( $bavotasan_theme_options['image_bar_category'] ); ?></h1>
				<?php
				}
				global $wp_customize;
				$posts_per_page = str_replace( 'c', '', $bavotasan_theme_options['image_bar_columns'] );
				$real_ppp = 12 / $posts_per_page;
				$posts_per_page = ( isset( $wp_customize ) ) ? 6 : $real_ppp;

				$image_bar_query = new WP_Query( array(
					'posts_per_page' => $posts_per_page,
					'cat' => (int) $bavotasan_theme_options['image_bar_category'],
					'ignore_sticky_posts' => 1,
					'no_found_rows' => true,
				) );

		        while ( $image_bar_query->have_posts() ) : $image_bar_query->the_post();
		        	$no_show = ( $real_ppp <= $image_bar_query->current_post ) ? ' no-show' : '';
		        	?>
		        	<div class="<?php echo $bavotasan_theme_options['image_bar_columns'] . $no_show; ?>">
						<?php
						$permalink = get_permalink();
						if ( has_post_thumbnail() ) {
		                    echo '<a href="' . $permalink . '">';
							the_post_thumbnail( 'image-bar-' . $bavotasan_theme_options['image_bar_columns'] );
							echo '</a>';
						}
						?>
						<p><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a></p>
		            </div>
		            <?php
		        endwhile;

		        wp_reset_postdata();
		        ?>
			</div>
		</div>
		<?php } ?>
	</div> <!-- #main -->

</div> <!-- #page.grid -->

<footer id="footer" role="contentinfo">
	<div id="footer-content" class="grid <?php echo $bavotasan_theme_options['width']; ?>">
		<div class="row">
			<?php dynamic_sidebar( 'extended-footer' ); ?>
		</div><!-- .row -->

		<div class="row">
			<p class="copyright c12">
				<?php $class = ( is_active_sidebar( 'extended-footer' ) ) ? ' active' : ''; ?>
				<span class="line<?php echo $class; ?>"></span>
				<span class="fl"><?php echo $bavotasan_theme_options['copyright']; ?></span>
				<span class="fr"><i class="icon-leaf"></i><?php printf( __( '%s created by %s.', 'magazine-premium' ), '<a href="http://themes.bavotasan.com/2010/magazine-premium/">Magazine Premium</a>', '<a href="http://themes.bavotasan.com">c.bavota</a>' ); ?></span>
			</p><!-- .c12 -->
		</div><!-- .row -->
	</div><!-- #footer-content.grid -->
</footer><!-- #footer -->

<?php wp_footer(); ?>
<!-- Magazine Premium created by c.bavota - http://themes.bavotasan.com -->
</body>
</html>