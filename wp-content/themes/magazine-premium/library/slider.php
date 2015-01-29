<?php
class Bavotasan_Slider {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 3 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        add_action( 'wp_ajax_search_content', array( $this, 'search_content' ) );
        add_action( 'wp_ajax_add_delete_slide', array( $this, 'add_delete_slide' ) );
        add_action( 'wp_ajax_edit_slide', array( $this, 'edit_slide' ) );

		add_action( 'wp_ajax_slide_order', array( $this, 'slide_order' ) );
	}

	/**
	 * Add a 'Slider' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() ) {
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'slider', 'title' => __( 'Slider', 'magazine-premium' ), 'href' => admin_url( 'themes.php?page=slider_page' ) ) );
	    }
	}

	/**
	 * Add a 'customize' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( __( 'Home Page Slider', 'magazine-premium' ), __( 'Slider', 'magazine-premium' ), 'edit_theme_options', 'slider_page', array( $this, 'slider_page' ) );
	}

	/**
	 * Add JS file for admin slider page.
	 *
	 * This function is attached to the 'admin_enqueue_scripts' action hook.
	 *
	 * @param	$hook  The page template file for the current page
	 *
	 * @uses	wp_enqueue_script()
	 * @uses	MP_THEME_URL
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts( $hook ) {
		if ( 'appearance_page_slider_page' == $hook  ) {
		    wp_enqueue_script( 'slider_options_js', MP_THEME_URL . '/library/js/slider-admin.js', array( 'jquery', 'jquery-ui-sortable' ), '', true );
			wp_enqueue_style( 'slider_options_css', MP_THEME_URL . '/library/css/slider-admin.css', false, null, 'all' );
			wp_enqueue_style( 'font_awesome', 'http://netdna.bootstrapcdn.com/font-awesome/3.0/css/font-awesome.css', false, null, 'all' );
			wp_enqueue_media();
		}
	}

	/**
	 * Registering the settings for the Custom CSS editor
	 *
	 * This function is attached to the 'admin_init' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_init() {
		register_setting( 'mp_slider', 'mp_slider' );
		register_setting( 'mp_slider_settings', 'mp_slider_settings',  array( $this, 'mp_slider_settings_validation' ) );

		add_settings_section( 'default', 'Default Settings', '__return_false', 'mp_slider_settings' );
		add_settings_field( 'mp_slider_settings_type', __( 'Type', 'magazine-premium' ), array( $this, 'input_select' ), 'mp_slider_settings', 'default', array( 'key' => 'type', 'hint' => __( 'Tabberota requires 4 slides. Taberrota Nu requires 5 slides. Both will only display the required number of slides.', 'magazine-premium' ) ) );
		add_settings_field( 'mp_slider_settings_category', __( 'Category', 'magazine-premium' ), array( $this, 'input_select' ), 'mp_slider_settings', 'default', array( 'key' => 'category', 'hint' => __( 'This setting is only utilized if no custom slides have been added below.', 'magazine-premium' ) ) );
		add_settings_field( 'mp_slider_settings_autoplay', __( 'Autoplay', 'magazine-premium' ), array( $this, 'input_checkbox' ), 'mp_slider_settings', 'default', array( 'key' => 'autoplay' ) );
		add_settings_field( 'mp_slider_settings_interval', __( 'Interval', 'magazine-premium' ), array( $this, 'input_regular' ), 'mp_slider_settings', 'default', array( 'key' => 'interval', 'hint' => __( 'Time in milliseconds before the slides switch if Autoplay is checked.', 'magazine-premium' ) ) );
	}


	/**
	 * Input select field
	 *
	 * @since 1.0.0
	 */
	public function input_select( $atts ) {
		$options = get_option( 'mp_slider_settings' );
		$value = ( empty( $options[$atts['key']] ) ) ? $this->default_settings( $atts['key'] ) : $options[$atts['key']]; ?>
		<?php if ( 'type' == $atts['key'] ) { ?>
		<select name="mp_slider_settings[<?php echo $atts['key']; ?>]">
			<option value="none"<?php selected( $value, 'none' ); ?>><?php _e( 'None', 'magazine-premium' ); ?></option>
			<option value="tabberota"<?php selected( $value, 'tabberota' ); ?>><?php _e( 'Tabberota', 'magazine-premium' ); ?></option>
			<option value="tabberota_nu"<?php selected( $value, 'tabberota_nu' ); ?>><?php _e( 'Tabberota Nu', 'magazine-premium' ); ?></option>
			<option value="sliderota"<?php selected( $value, 'sliderota' ); ?>><?php _e( 'Sliderota', 'magazine-premium' ); ?></option>
			<option value="scrollerota"<?php selected( $value, 'scrollerota' ); ?>><?php _e( 'Scrollerota', 'magazine-premium' ); ?></option>
		</select>
		<?php } else {
			wp_dropdown_categories( 'show_option_all=All&hide_empty=0&name=mp_slider_settings[' . $atts['key'] . ']&selected=' . $value );
		} ?>
		<?php
		if ( ! empty( $atts['hint'] ) ) echo '<p class="description">' . $atts['hint'] . '</p>';
	}

	/**
	 * Input field
	 *
	 * @since 1.0.0
	 */
	public function input_regular( $atts ) {
		$options = get_option( 'mp_slider_settings' );
		$value = ( empty( $options[$atts['key']] ) ) ? $this->default_settings( $atts['key'] ) : $options[$atts['key']];
		echo '<input value="' . $value . '" name="mp_slider_settings[' . $atts['key'] . ']" type="type" />';
		if ( ! empty( $atts['hint'] ) ) echo '<p class="description">' . $atts['hint'] . '</p>';
	}

	/**
	 * Checkbox input
	 *
	 * @since 1.0.0
	 */
	public function input_checkbox( $atts ) {
		$options = get_option( 'mp_slider_settings' );
		$value = ( empty( $options[$atts['key']] ) ) ? $this->default_settings( $atts['key'] ) : $options[$atts['key']];
		echo '<input ' . checked( $value, true, false ) . ' value="1" name="mp_slider_settings[' . $atts['key'] . ']" type="checkbox" />';
	}

	/**
	 * Default settings
	 *
	 * @since 1.0.0
	 */
	public function default_settings( $name = null ) {
		$default = array(
			'type' => 'none',
			'autoplay' => '0',
			'interval' => '4000',
			'category' => '0'
		);

		return ( $name ) ? $default[$name] : $default;
	}

	/**
	 * Slider page
	 *
	 * @since 1.0.0
	 */
	public function slider_page() {
		$slider_items = get_option( 'mp_slider' );
		$count = ( empty( $slider_items ) ) ? 0 : count( $slider_items );
		?>
		<div class="wrap" id="slider-options">
			<?php screen_icon(); ?>
			<h2><?php echo get_admin_page_title(); ?></h2>
			<?php settings_errors(); ?>

			<form action="options.php" method="post">
				<?php settings_fields( 'mp_slider_settings' ); ?>
				<?php do_settings_sections( 'mp_slider_settings' ); ?>
				<?php submit_button(); ?>
			</form>

			<h3><?php _e( 'Add Post/Page to Slider', 'magazine-premium' ); ?></h3>
			<form id="slider-form" method="post" action="" data-count="<?php echo $count; ?>">
				<?php wp_nonce_field( 'slider_nonce', 'slider_nonce' ); ?>
				<?php _e( 'Search by content:', 'magazine-premium' ); ?>
				<input type="text" id="content_search" name="content_search" placeholder="<?php _e( 'Start typing...', 'magazine-premium' ); ?>">
				<p id="content_search_results"></p>
				<?php submit_button( __( 'Add to Slider', 'magazine-premium' ), 'submit', 'add_to_slider', '', array( 'disabled' => 'disabled' ) ); ?>
			</form>

			<p>&nbsp;</p>

			<h3 class="spinner-header"><?php _e( 'Current Slider Items', 'magazine-premium' ); ?><span id="slider-spinner" class="spinner"></span></h3>
			<div id="admin-slides">
				<?php
				//delete_option( 'mp_slider' );
				if ( ! empty( $slider_items ) ) {
					$count = 0;
					foreach( $slider_items as $slide ) {
						echo $this->format_slide( $slide, $count );
						$count++;
					}
				}
				?>
			</div>
		</div>
		<?php
	}

	/**
	 * Properly format each slide for display
	 *
	 * @since 1.0.0
	 */
	public function format_slide( $slide, $count ) {
		$return = '
		<div id="slide_' . $count . '" class="slide">
			<div class="icon"><i class="icon-move"></i></div>
			<div class="image">';
		if ( $slide['image_url'] )
			$return .= '<img src="' . esc_url( $slide['image_url'] ) . '" alt="" />';
		else
			$return .='<span></span>';
		$return .= '
			</div>
			<div class="text">
				<p><strong>' . __( 'Title:', 'magazine-premium' ) . '</strong><span class="item item-title">'. stripslashes( $slide['title'] ) . '</span></p>
				<p><strong>' . __( 'Text:', 'magazine-premium' ) . '</strong><span class="item item-excerpt">'. stripslashes( $slide['excerpt'] ) . '</span></p>
				<p><strong>' . __( 'Link:', 'magazine-premium' ) . '</strong><span class="item item-link">'. esc_url( $slide['link'] ) . '</span></p>
			</div>
			<div class="options"><a href="#" class="edit-slide" data-slide="' . $count . '">' . __( 'Edit', 'magazine-premium' ) . '</a> | <a href="#" class="delete-slide" data-slide="' . $count . '">X</a></div>
		</div>';

		return $return;
	}

	/**
	 * The slider settings validation
	 *
	 * @since 1.0.0
	 */
	public function mp_slider_settings_validation( $input ) {
		$input['type'] =  strip_tags( $input['type'] );
		$input['autoplay'] = ( empty( $input['autoplay'] ) ) ? '' : (bool) $input['autoplay'];
		$input['interval'] = (int) $input['interval'];
		return $input;
	}

    /**
     * Search helper to return matched posts/pages
     *
     * @since 1.0.0
     */
    function search_content() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
            return;

        $search_query = new WP_Query( array(
            'posts_per_page' => 5,
            'post_type' => array( 'post', 'page' ),
            's' => $_POST['query'],
            'fields' => array( 'id', 'post_title' ),
            'no_found_rows' => true
        ) );

        $data = '<em>' . __( 'Nothing found', 'magazine-premium' ) . '</em>';
        $success = false;

        if ( $search_query->have_posts() ) {
        	$data = '<select name="search-results" id="search-results" style="height: auto; padding: 6px;" size="' . ( $search_query->post_count + 1 ) . '">';
            foreach ( $search_query->get_posts() as $recent ) {
            	$data .= '<option data-post_id="' . $recent->ID . '" value="' . $recent->ID . '">' . $recent->post_title . '</option>';
            }
            $data .= '</select>';
            $success = true;
        }

        echo json_encode( array(
        	'success' => $success,
        	'data' => $data
        ) );
        die();
    }

    /**
     * Adds a slide to a slider
     *
     * @since 1.0.0
     */
    public function add_delete_slide() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
            return;

		$success = false;
		$data = __( 'There was an error. Please try again.', 'magazine-premium' );

        $sliders = get_option( 'mp_slider' , array() );

        if ( isset( $_POST['post_id'] ) ) {
	        $post_id = ( $_POST['post_id'] );
	        if ( 'add' == $_POST['a_or_d'] ) {
	        	$the_post = get_post( $post_id );
	            $new_slide = array( );
	            $new_slide['title'] = get_the_title( $post_id );
   				$excerpt = ( $the_post->post_excerpt ) ? $the_post->post_excerpt : $the_post->post_content;
	            $new_slide['excerpt'] = wp_trim_words( apply_filters( 'the_content', $excerpt ), 30 );
	            $new_slide['link'] = get_permalink( $post_id );
				$image_url = get_post_meta( $the_post->ID, 'mp_slider_image', true );
				if ( ! $image_url ) {
					$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );
					$image_url = $image_url[0];
				}
	            $new_slide['image_url'] = $image_url;

	            $sliders[] = $new_slide;

				$data = $this->format_slide( $new_slide, $_POST['count'] );
			} else {
	            array_splice( $sliders, $post_id, 1 );
	            $data = '';
			}

            $success = true;
	        update_option( 'mp_slider', $sliders );
	    }
        echo json_encode( array(
        	'success' => $success,
        	'data' => $data
        ) );

        die();
    }

    /**
     * Edit slide
     *
     * @since 1.0.0
     */
    public function edit_slide() {
        if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
            return;

		$success = false;
		$data = __( 'There was an error. Please try again.', 'magazine-premium' );

        $sliders = get_option( 'mp_slider' , array() );

        if ( isset( $_POST['slide_id'] ) ) {
            $slide_id = $_POST['slide_id'];
            $sliders[$slide_id]['title'] = sanitize_text_field( $_POST['new_title'] );
            $sliders[$slide_id]['excerpt'] = sanitize_text_field( $_POST['new_excerpt'] );
            $sliders[$slide_id]['link'] = esc_url( $_POST['new_link'] );
            $sliders[$slide_id]['image_url'] = esc_url( $_POST['new_image_url'] );

			$data = $this->format_slide( $sliders[$slide_id], $slide_id );

            $success = true;
	        update_option( 'mp_slider', $sliders );
	    }
        echo json_encode( array(
        	'success' => $success,
        	'data' => $data
        ) );

        die();
    }

	/**
	 * Reorder slides
	 *
	 * @since 1.0.0
	 */
	public function slide_order() {
		if ( ! empty( $_POST['nonce'] ) && ! wp_verify_nonce( $_POST['nonce'], 'slider_nonce' ) )
			return;

		if ( isset( $_POST['slide_order'] ) ) {
			$new_slide_array = array();
			$sliders = get_option( 'mp_slider' );
			foreach ( $_POST['slide_order'] as $order ) {
				$order = str_replace( 'slide_', '', $order );
				$new_slide_array[] = $sliders[$order];
			}
			update_option( 'mp_slider', $new_slide_array );
		}
		die();
	}

	/**
	 * Display the slider
	 *
	 * @since 1.0.0
	 */
	public function display_slider() {
		$bavotasan_theme_options = mp_theme_options();
		//delete_option( 'mp_slider_settings' );
		$slider_options = get_option( 'mp_slider_settings', $this->default_settings());
		$slider_items = get_option( 'mp_slider' );
		if ( 'none' != $slider_options['type'] ) :
			$count = count( $slider_items );
			if ( empty( $slider_items ) ) {
				$posts_per_page = ( 'tabberota' == $slider_options['type'] ) ? 4 : 5;
				$posts_array = get_posts( array(
					'posts_per_page' => $posts_per_page,
					'category' => $slider_options['category'],
					'no_found_rows' => true,
				) );
				$count = 0;
				foreach( $posts_array as $the_post ) {
					$slider_items[$count]['link'] = get_permalink( $the_post->ID );
					$slider_items[$count]['title'] = $the_post->post_title;
					$excerpt = ( $the_post->post_excerpt ) ? $the_post->post_excerpt : $the_post->post_content;
					$slider_items[$count]['excerpt'] = wp_trim_words( apply_filters( 'the_content', $excerpt ), 20 );
					$image_url = get_post_meta( $the_post->ID, 'mp_slider_image', true );
					if ( ! $image_url ) {
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $the_post->ID ), 'large' );
						$image_url = $image_url[0];
					}
					$slider_items[$count]['image_url'] = $image_url;
					$count++;
				}
				wp_reset_postdata();
			}
			$slide_class = ( 'sliderota' == $slider_options['type'] || 'scrollerota' == $slider_options['type'] ) ? ' slides-' . $count : '';
			?>

			<div id="slider-wrap" class="<?php echo $slider_options['type'] . $slide_class; ?>">
				<?php
				if ( ! empty( $slider_items ) ) {
					$images = '';
					$content = '';
					$dots = '';
					$slide_count = 0;
					foreach( $slider_items as $slide ) {
						$selected = ( $slide_count ) ? '' : 'selected';
						if ( 'sliderota' == $slider_options['type'] || 'scrollerota' == $slider_options['type'] ) {
							$images .= '<a href="' . esc_url( $slide['link'] ) . '" class="image-anchor"><img src="' . esc_url( $slide['image_url'] ) . '" alt="" class="slide_' . $slide_count . '" /></a>';
							$dots .= '<span class="' . $selected . '" data-slide="' . $slide_count . '"></span>';
						}
						if ( 'tabberota' == $slider_options['type'] || 'tabberota_nu' == $slider_options['type'] ) {
							$title = ( 'tabberota' == $slider_options['type'] ) ? '<h2>' . stripslashes( $slide['title'] ) . '</h2>' : '';
							$images .= '<div class="tab ' . $selected . '" data-tab="' . $slide_count . '"><img src="' . esc_url( $slide['image_url'] ) . '" alt="" />' . $title . '</div>';
						}
						if ( 'scrollerota' == $slider_options['type'] || 'tabberota' == $slider_options['type'] || 'tabberota_nu' == $slider_options['type'] ) {
							$content .= ( 'scrollerota' == $slider_options['type'] ) ? '<article class="slide ' . $selected . '">' : '<article class="slide ' . $selected . '"><div class="text">';
							$content .= '<h1><a href="' . esc_url( $slide['link'] ) . '">' . stripslashes( $slide['title'] ) . '</a></h1>
								<p>' . stripslashes( $slide['excerpt'] ) . '</p>';
							$content .=	( 'scrollerota' == $slider_options['type'] ) ? '<a href="' . esc_url( $slide['link'] ) . '" class="more-link">' . $bavotasan_theme_options['read_more'] . '</a></article>' : '</div><a href="' . esc_url( $slide['link'] ) . '" class="image-anchor"><img src="' . esc_url( $slide['image_url'] ) . '" alt="" class="' . $selected . ' slide_' . $slide_count . '" /></a></article>';
						}
						$slide_count++;
					}
				}
				?>
				<div class="images"><?php echo $images; ?></div>
				<div class="content"><?php echo $content; ?></div>
				<div class="mobile-controls">
					<span class="mobile-prev"><i class="icon-chevron-left"></i></span>
					<span class="mobile-next"><i class="icon-chevron-right"></i></span>
				</div>
				<div class="dot-selector"><?php echo $dots; ?></div>
			</div>
			<?php
		endif;
	}
}
$bavotasan_slider = new Bavotasan_Slider;