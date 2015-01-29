<?php
global $mp_content_area, $mp_afp_columns;
$class = mp_home_page_class( $mp_afp_columns );
$format = ( function_exists( 'has_post_format' ) ) ? get_post_format() : '';
$image_alignment = ( isset( $mp_afp_columns['image_alignment'] ) && 'main' == $mp_content_area ) ? $mp_afp_columns['image_alignment'] : 'alignleft';
$bavotasan_theme_options = mp_theme_options();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	    <?php get_template_part( 'content', 'header' ); ?>

	    <div class="entry-content">
		    <?php
			if ( ! is_singular() && ( empty( $mp_afp_columns ) && 'excerpt' == $bavotasan_theme_options['excerpt_content'] ) || 'excerpt' == $mp_afp_columns['excerpt_content'] ||  'sidebar' == $mp_content_area ) {
		    	if ( ! empty( $mp_afp_columns ) && 'sidebar' != $mp_content_area ) {
			    	$image_name = array( $mp_afp_columns['image_width'], 999 );
			    } else {
			    	$image_name = 'thumbnail';
			    	if ( 'main' == $mp_content_area && is_home() ) {
				    	$pos = strpos( $class, 'three-col c4' );
				    	$pos2 = strpos( $class, 'two-col c6' );
			    		$image_name = ( $pos !== false && is_home() ) ? '3_column' : '1_column';
			    		$image_name = ( $pos2 !== false && is_home() ) ? '2_column' : $image_name;
			    	}
	    		}

	    		$size = ( 'image' == $format ) ? 'full' : $image_name;
				if ( has_post_thumbnail() ) {
					echo '<a href="' . get_permalink() . '" class="image-anchor">';
					the_post_thumbnail( $size, array( 'class' => $image_alignment ) );
					echo '</a>';
				}
				echo '<div class="excerpt">';
				global $bavotasan_custom_excerpt_length;
				if ( ! empty( $mp_afp_columns['excerpt_length'] ) )
					$bavotasan_custom_excerpt_length = $mp_afp_columns['excerpt_length'];
				the_excerpt();
				$bavotasan_custom_excerpt_length = 0;
				echo '</div>';
			} else {
			    the_content( __( $bavotasan_theme_options['read_more'], 'magazine-premium' ) );
			}
			?>
	    </div><!-- .entry-content -->

	    <?php get_template_part( 'content', 'footer' ); ?>
	</article><!-- #post-<?php the_ID(); ?> -->