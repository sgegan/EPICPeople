<?php
class Bavotasan_Custom_Metaboxes {
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_custom_metabox' ) );
		add_action( 'save_post', array( $this, 'mp_save_custom_box' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Enqueue script to select image on post edit screen
	 *
	 * This function is attached to the 'admin_enqueue_scripts' action hook.
	 *
	 * @since 2.0.0
	 */
	public function admin_enqueue_scripts( $hook ) {
		if ( 'post.php' == $hook || 'post-new.php' == $hook )
		    wp_enqueue_script( 'custom_image', MP_THEME_URL . '/library/js/custom-image.js', array( 'jquery' ), '', true );
	}

	/**
	 * Add option for full width posts & pages
	 *
	 * This function is attached to the 'add_meta_boxes' action hook.
	 *
	 * @since 2.0.0
	 */
	public function add_custom_metabox() {
		add_meta_box( 'theme-layout-options', __( 'Layout', 'magazine-premium' ), array( $this, 'mp_layout_option' ), 'post', 'side', 'high' );
		add_meta_box( 'theme-layout-options', __( 'Layout', 'magazine-premium' ), array( $this, 'mp_layout_option' ), 'page', 'side', 'high' );

		add_meta_box( 'theme-headline', __( 'Headline', 'magazine-premium' ), array( $this, 'mp_headline' ), 'post', 'normal', 'high' );
		add_meta_box( 'theme-slider-image', __( 'Custom Slider Image', 'magazine-premium' ), array( $this, 'mp_slider_image' ), 'post', 'normal', 'high' );
	}

	public function mp_layout_option( $post ) {
		$layout = get_post_meta( $post->ID, 'mp_single_layout', true );

		// Use nonce for verification
		wp_nonce_field( 'mp_nonce', 'mp_nonce' );

		echo '<input id="mp_single_layout" name="mp_single_layout" type="checkbox" '; checked( $layout, 'on' ); echo ' /> <label for="mp_single_layout">' . __( 'Display at full width', 'magazine-premium' ) . '</label>';
	}

	public function mp_headline( $post ) {
		$headline = get_post_meta( $post->ID, 'mp_headline', true );

		// Use nonce for verification
		wp_nonce_field( 'mp_nonce', 'mp_nonce' );

		echo '<textarea id="mp_headline" name="mp_headline" rows="4" cols="40" style="height: 4em;width: 98%;">' . esc_textarea( $headline ) . '</textarea>';
		echo '<p>' . __( 'The headline will appear on standard posts on the single post template below the title/meta.', 'magazine-premium' ) . '</p>';
	}

	public function mp_slider_image( $post ) {
		$slider_image = get_post_meta( $post->ID, 'mp_slider_image', true );
		$img_src = ( $slider_image ) ? '<img src="' . $slider_image . '" alt="" style="max-width:100%;" />' : '';

		// Use nonce for verification
		wp_nonce_field( 'mp_nonce', 'mp_nonce' );

		echo '<p id="custom-image-container">' . $img_src . '</p>';
		echo '<input type="hidden" id="mp_slider_image" name="mp_slider_image" value="' . esc_attr( $slider_image ) . '" />';
		echo '<p><button class="button-primary select_image">' . __( 'Set Image', 'magazine-premium' ) . '</button> <button class="button delete_image">' . __( 'Remove Image', 'magazine-premium' ) . '</button></p>';
		echo '<p>' . __( 'Set a custom image for the slider if you want to use something other than the featured image.', 'magazine-premium' ) . '</p>';
	}

	/**
	 * Save post custom fields
	 *
	 * This function is attached to the 'save_post' action hook.
	 *
	 * @since 2.0.0
	 */
	public function mp_save_custom_box( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( ! empty( $_POST['mp_nonce'] ) && ! wp_verify_nonce( $_POST['mp_nonce'], 'mp_nonce' ) )
			return;

		if ( ! empty( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return;
		}

		$this->save_meta_value( $post_id, 'mp_single_layout' );
		$this->save_meta_value( $post_id, 'mp_headline' );
		$this->save_meta_value( $post_id, 'mp_slider_image' );
	}

	/**
	 * Save meta helper function
	 *
	 * @param	int $post_id	The post id
	 * @param	string $name	The custom field meta key
	 *
	 * @since 2.0.0
	 */
	public function save_meta_value( $post_id, $name ) {
		$value = ( empty( $_POST[$name] ) ) ? '' : $_POST[$name];
		if ( $value )
			update_post_meta( $post_id, $name, $value );
		else
			delete_post_meta( $post_id, $name );
	}
}
$bavotasan_custom_metaboxes = new Bavotasan_Custom_Metaboxes;

/**
 * Full width conditional check
 *
 * @since 2.0.0
 *
 * @return	boolean
 */
function is_mp_full_width() {
	$bavotasan_theme_options = mp_theme_options();

	if ( is_singular() ) {
		$single_layout = get_post_meta( get_the_ID(), 'mp_single_layout', true );
		if ( 'on' == $single_layout )
			return true;
	}
}