<?php
/**
 * Functionality for Authors widget
 *
 * @since 2.0.0
 */
class MP_Authors_Widget extends WP_Widget {
	function MP_Authors_Widget() {
		$widget_ops = array( 'classname' => 'mp_authors', 'description' => __( 'Display a list of authors', 'magazine-premium' ) );
		$this->WP_Widget( 'mp_authors', '(' . BAVOTASAN_THEME_NAME . ') ' . __( 'List Authors', 'magazine-premium' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$display_admins = strip_tags( $instance['display_admins'] );
		$order_by = strip_tags( $instance['order_by'] );
		$role = 'author';
		$avatar_size = (int) $instance['avatar_size'];
		$authors = array();

		echo $before_widget;

	    if ( ! empty( $title ) )
	    	echo $before_title . $title . $after_title;

		if ( ! empty( $display_admins ) )
			$blogusers = array_merge( get_users( 'orderby=' . $order_by . '&role=administrator' ), get_users( 'orderby=' . $order_by . '&role=' . $role ) );
		else
			$blogusers = get_users( 'orderby=' . $order_by . '&role=' . $role );
		?>
		<ul>
			<?php
			foreach ( $blogusers as $author ) {
				$author_profile_url = get_author_posts_url( $author->ID );
				?>
				<li>
					<a href="<?php echo $author_profile_url; ?>"><?php echo get_avatar( $author->user_email, $avatar_size ); ?></a>
					<a href="<?php echo $author_profile_url; ?>" class="author-link"><?php echo $author->display_name; ?></a>
				</li>
				<?php
			}
			?>
		</ul>
		<?php
		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => 'Authors',
			'display_admins' => '',
			'order_by' => 'display_name',
			'avatar_size' => '60',
		) );

		$title = strip_tags( $instance['title'] );
		$display_admins = strip_tags( $instance['display_admins'] );
		$order_by = strip_tags( $instance['order_by'] );
		$avatar_size = (int) $instance['avatar_size'];
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'magazine-premium' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id( 'order_by' ); ?>"><?php _e( 'Order by', 'magazine-premium' ); ?>:
			<select class="widefat" id="<?php echo $this->get_field_id( 'order_by' ); ?>" name="<?php echo $this->get_field_name( 'order_by' ); ?>">
				<option value="nicename" <?php selected( $order_by, 'nicename' ); ?>><?php _e( 'Nicename', 'magazine-premium' ); ?></option>
				<option value="email" <?php selected( $order_by, 'email' ); ?>><?php _e( 'Email', 'magazine-premium' ); ?></option>
				<option value="url" <?php selected( $order_by, 'url' ); ?>><?php _e( 'URL', 'magazine-premium' ); ?></option>
				<option value="registered" <?php selected( $order_by, 'registered' ); ?>><?php _e( 'Registered', 'magazine-premium' ); ?></option>
				<option value="display_name" <?php selected( $order_by, 'display_name' ); ?>><?php _e( 'Display Name', 'magazine-premium' ); ?></option>
				<option value="post_count" <?php selected( $order_by, 'post_count' ); ?>><?php _e( 'Post Count', 'magazine-premium' ); ?></option>
			</select>
		</label></p>
		<p><label for="<?php echo $this->get_field_id( 'avatar_size' ); ?>"><?php _e( 'Avatar size', 'magazine-premium' ); ?>:</label> <input size="3" id="<?php echo $this->get_field_id( 'avatar_size' ); ?>" name="<?php echo $this->get_field_name( 'avatar_size' ); ?>" type="text" value="<?php echo esc_attr( $avatar_size ); ?>" /></p>
		<p><input class="checkbox" id="<?php echo $this->get_field_id( 'display_admins' ); ?>" name="<?php echo $this->get_field_name( 'display_admins' ); ?>" type="checkbox" <?php checked( $display_admins, 'on' ); ?> /> <label for="<?php echo $this->get_field_id( 'display_admins' ); ?>"><?php _e( 'Display Admins', 'magazine-premium' ); ?></label> </p>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['display_admins'] = strip_tags( $new_instance['display_admins'] );
		$instance['order_by'] = strip_tags( $new_instance['order_by'] );
		$instance['avatar_size'] = (int) $new_instance['avatar_size'];
		return $instance;
	}
}
register_widget( 'MP_Authors_Widget' );