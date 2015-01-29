<?php
/**
 * The template for displaying article headers
 *
 * @since 3.0.0
 */
global $mp_content_area;
$format = ( function_exists( 'has_post_format' ) ) ? get_post_format() : '';
$icon = array( 'audio' => 'icon-music', 'video' => 'icon-film', '0' => 'icon-file', 'image' => 'icon-picture', 'gallery' => 'icon-camera-retro', 'chat' => 'icon-bullhorn' );
$bavotasan_theme_options = mp_theme_options();
?>
<header>
	<?php
	$display_categories = $bavotasan_theme_options['display_categories'];
	if ( $display_categories && 'page' != get_post_type() ) { ?>
	<h3 class="post-category"><i class="<?php echo $icon[$format]; ?>"></i><?php the_category( ', ' ); ?></h3>
		<?php
	}
	?>
	<h1 class="entry-title">
		<?php if ( ! is_singular() || 'sidebar' == $mp_content_area ) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		<?php } ?>
			<?php the_title(); ?>
		<?php
		if ( ! is_singular() || 'sidebar' == $mp_content_area )
			echo '</a>';
		?>
	</h1>

	<?php if ( 'page' != get_post_type() ) { ?>
	<h2 class="entry-meta">
		<?php
		$display_author = $bavotasan_theme_options['display_author'];
		if ( $display_author )
			printf( __( 'by %s', 'magazine-premium' ),
				'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( sprintf( __( 'Posts by %s', 'magazine-premium' ), get_the_author() ) ) . '" rel="author">' . get_the_author() . '</a>'
			);

		$display_date = $bavotasan_theme_options['display_date'];
		if ( $display_date ) {
			if ( $display_author )
				echo '&nbsp;&bull;&nbsp;';
            echo '<time class="published updated" datetime="' . get_the_date( 'Y-m-d' ) . '">' . get_the_date() . '</time>';
		}
		if ( 'sidebar' != $mp_content_area ) {
			$display_comment_count = $bavotasan_theme_options['display_comment_count'];
			if ( comments_open() && $display_comment_count ) {
				if ( $display_author || $display_date )
					echo '&nbsp;&bull;&nbsp;';
				comments_popup_link( __( '0 Comments', 'magazine-premium' ), __( '1 Comment', 'magazine-premium' ), __( '% Comments', 'magazine-premium' ) );
			}
		}
		?>
	</h2>
	<?php } ?>
</header>