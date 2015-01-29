<?php
/**
 * Functionality for Featured Post widget
 *
 * @since 2.0.0
 */
class MP_FeaturedPosts_Widget extends WP_Widget {
	function MP_FeaturedPosts_Widget() {
		$widget_ops = array( 'classname' => 'mp_featured_posts', 'description' => __( 'Display featured posts from a category', 'magazine-premium' ) );
		$this->WP_Widget( 'mp_featured_posts', '(' . BAVOTASAN_THEME_NAME . ') ' . __( 'Featured Posts', 'magazine-premium' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$sticky = get_option( 'sticky_posts' );

		if( is_single() )
			array_push( $sticky, get_the_ID() );

		echo $before_widget;
	    if ( !empty( $title) )
	    	echo $before_title . $title . $after_title;

		$featuredPosts = new WP_Query( array(
			'posts_per_page' => (int) $instance['number'],
			'cat' => (int) $instance['category'],
			'post__not_in' => $sticky,
			'no_found_rows' => true
		) );

	    while ($featuredPosts->have_posts()) : $featuredPosts->the_post();
	    	global $mp_content_area;
	    	$mp_content_area = 'sidebar';
	    	get_template_part( 'content', get_post_format() );
		endwhile;

		wp_reset_postdata();

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Featured Posts', 'category' => '0', 'number' => '1' ) );
		$title = strip_tags( $instance['title'] );
		$category = strip_tags( $instance['category'] );
		$number = strip_tags( $instance['number'] );
		$selectname = $this->get_field_name( 'category' );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'magazine-premium' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'magazine-premium' ); ?>: <?php wp_dropdown_categories( 'show_option_all=' . __( 'All', 'magazine-premium' ) . ' &hide_empty=0&name=' . $selectname . '&selected=' . $category ); ?></label></p>
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Posts', 'magazine-premium' ); ?>:</label> <input size="3" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" /></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];
		$instance['number'] = (int) $new_instance['number'];
		return $instance;
	}

}
register_widget( 'MP_FeaturedPosts_Widget' );