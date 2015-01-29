<?php
class Bavotasan_Advanced_Front_Page {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 2 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		add_action( 'wp_ajax_add_new_section', array( $this, 'add_new_section' ) );
		add_action( 'wp_ajax_delete_section', array( $this, 'delete_section' ) );

		if ( ! get_option( 'mp_advanced_front_page' ) )
			add_option( 'mp_advanced_front_page', array(
				'lower_content_width' => 'c9',
				'lower_content_alignment' => 'right',
			) );
	}

	/**
	 * Add an 'Advanced Front Page' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 2.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
	       	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'advanced_front_page', 'title' => __( 'Advanced Front Page', 'magazine-premium' ), 'href' => admin_url( 'themes.php?page=advanced_front_page' ) ) );
	}

	/**
	 * Add a 'customize' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 2.0.0
	 */
	public function admin_menu() {
		add_theme_page( __( 'Advanced Front Page', 'magazine-premium' ),  __( 'Advanced Front Page', 'magazine-premium' ), 'edit_theme_options', 'advanced_front_page', array( $this, 'advanced_front_page' ) );
	}

	/**
	 * Registering the settings for the Custom CSS editor
	 *
	 * This function is attached to the 'admin_init' action hook.
	 *
	 * @since 2.0.0
	 */
	public function admin_init() {
		register_setting( 'mp_advanced_front_page', 'mp_advanced_front_page',  array( $this, 'advanced_front_page_validation' ) );
	}

	/**
	 * Add JS file to admin only on Custom CSS editor page.
	 *
	 * This function is attached to the 'admin_enqueue_scripts' action hook.
	 *
	 * @param	$hook  The page template file for the current page
	 *
	 * @uses	wp_enqueue_script()
	 * @uses	MP_THEME_URL
	 *
	 * @since 2.0.0
	 */
	public function admin_enqueue_scripts( $hook ) {
		if ( 'appearance_page_advanced_front_page' == $hook ) {
		    wp_enqueue_script( 'advanced_front_page', MP_THEME_URL . '/library/js/advanced-front-page.js', array( 'jquery' ), '', true );
			wp_enqueue_style( 'advanced_front_page_css', MP_THEME_URL . '/library/css/advanced-front-page.css', false, null, 'all' );
		}
	}

	/**
	 * The Advanced Front Page validation
	 *
	 * @since 2.0.0
	 */
	public function advanced_front_page_validation( $input ) {
		return $input;
	}

	/**
	 * The Advanced Front Page appearance page
	 *
	 * @since 2.0.0
	 */
	public function advanced_front_page() {
		$advanced_front_page = get_option( 'mp_advanced_front_page' );
		//delete_option( 'mp_advanced_front_page' );
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php echo get_admin_page_title(); ?></h2>
			<?php if ( ! empty( $_GET['settings-updated'] ) ) echo '<div id="message" class="updated"><p><strong>' . __( 'Advanced Front Page updated.', 'magazine-premium' ) . '</strong></p></div>'; ?>
			<form id="advanced_front_page_form" method="post" action="options.php">
				<h3><?php _e( 'Upper Layout', 'magazine-premium' ); ?></h3>
				<p><?php _e( 'This is the upper area of the front page. You can manipulate how your posts appear using the section controls below. Click on the "Add New Upper Section" button to get started.', 'magazine-premium' ); ?></p>

				<p><a href="#" data-type="upper" class="add-new-section button"><?php _e( 'Add New Upper Section', 'magazine-premium' ); ?></a></p>

	            <?php settings_fields( 'mp_advanced_front_page' ); ?>

	            <?php
	            if ( isset( $advanced_front_page['upper'] ) ) {
		            $this->page_content( $advanced_front_page, 'upper' );
		        }
	            ?>

		        <br class="clear" />

		        <h3><?php _e( 'Lower Layout', 'magazine-premium' ); ?></h3>
				<p><?php _e( 'This is the lower area of the front page. You can manipulate how your posts appear using the section controls below. Click on the "Add New Lower Section" button to get started.', 'magazine-premium' ); ?></p>

				<p>
				<label><?php _e( 'Lower Content Width:', 'magazine-premium' ); ?> </label>
				<select name="mp_advanced_front_page[lower_content_width]">
					<option value="c2"<?php selected( $advanced_front_page['lower_content_width'], 'c2' ); ?>>17%</option>
					<option value="c3"<?php selected( $advanced_front_page['lower_content_width'], 'c3' ); ?>>25%</option>
					<option value="c4"<?php selected( $advanced_front_page['lower_content_width'], 'c4' ); ?>>34%</option>
					<option value="c5"<?php selected( $advanced_front_page['lower_content_width'], 'c5' ); ?>>42%</option>
					<option value="c6"<?php selected( $advanced_front_page['lower_content_width'], 'c6' ); ?>>50%</option>
					<option value="c7"<?php selected( $advanced_front_page['lower_content_width'], 'c7' ); ?>>58%</option>
					<option value="c8"<?php selected( $advanced_front_page['lower_content_width'], 'c8' ); ?>>66%</option>
					<option value="c9"<?php selected( $advanced_front_page['lower_content_width'], 'c9' ); ?>>75%</option>
					<option value="c10"<?php selected( $advanced_front_page['lower_content_width'], 'c10' ); ?>>83%</option>
					<option value="c12"<?php selected( $advanced_front_page['lower_content_width'], 'c12' ); ?>>100%</option>
				</select>
				</p>

				<p>
				<label><?php _e( 'Lower Sidebar Alignment:', 'magazine-premium' ); ?> </label>
				<select name="mp_advanced_front_page[lower_content_alignment]">
					<option value="left"<?php selected( $advanced_front_page['lower_content_alignment'], 'left' ); ?>><?php _e( 'Left', 'magazine-premium' ); ?></option>
					<option value="right"<?php selected( $advanced_front_page['lower_content_alignment'], 'right' ); ?>><?php _e( 'Right', 'magazine-premium' ); ?></option>
				</select>
				</p>

				<p><a href="#" data-type="lower" class="add-new-section button"><?php _e( 'Add New Lower Section', 'magazine-premium' ); ?></a></p>

	            <?php
	            if ( isset( $advanced_front_page['lower'] ) ) {
		            $this->page_content( $advanced_front_page, 'lower' );
		        }
				?>

				<p class="submit-button-p"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'magazine-premium' ) ?>" /></p>
			</form>
	    </div>
	    <?php
	}

	/**
	 * The Advanced Front Page content
	 *
	 * @since 2.0.0
	 */
	public function page_content( $advanced_front_page, $section ) {
        $count = 0;
        foreach ( $advanced_front_page[$section] as $afp_section ) {
            $afp_section['separator'] = ( isset( $afp_section['separator'] ) ) ? $afp_section['separator'] : '';
            $afp_section['link'] = ( isset( $afp_section['link'] ) ) ? $afp_section['link'] : '';
            ?>
            <div class="section-wrap">
            	<h2><?php printf( __( 'Section %s', 'magazine-premium' ),  $count + 1 ); ?> <a href="#" class="delete-section" data-type="<?php echo $section; ?>" data-section="<?php echo $count; ?>">X</a></h2>

	            <p><label><?php _e( 'Title', 'magazine-premium' ); ?></label><br />
	            <input type="text" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][title]" value="<?php echo $afp_section['title']; ?>" />
	            </p>

	            <p><input type="checkbox" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][link]"<?php checked( $afp_section['link'], 'on' ); ?> /> <label><?php _e( 'Link Title to Category', 'magazine-premium' ); ?></label>
	            </p>

	            <p><label><?php _e( 'Category', 'magazine-premium' ); ?><br />
	            <?php wp_dropdown_categories( 'show_option_all=' . __( 'All', 'magazine-premium' ) . ' &hide_empty=0&name=mp_advanced_front_page[' . $section . '][' . $count . '][category]&selected=' . $afp_section['category'] ); ?></label></p>

	            <p><label><?php _e( 'Image Alignment', 'magazine-premium' ); ?></label><br />
	            <select name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][image_alignment]">
	            	<option value="alignnone"<?php selected( $afp_section['image_alignment'], 'alignnone'); ?>><?php _e( 'None', 'magazine-premium' ) ?></option>
	            	<option value="alignleft"<?php selected( $afp_section['image_alignment'], 'alignleft'); ?>><?php _e( 'Left', 'magazine-premium' ) ?></option>
	            	<option value="alignright"<?php selected( $afp_section['image_alignment'], 'alignright'); ?>><?php _e( 'Right', 'magazine-premium' ) ?></option>
	            </select>
	            </p>

	            <p><label><?php _e( 'Image Width', 'magazine-premium' ); ?></label><br />
	            <input type="text" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][image_width]" value="<?php echo $afp_section['image_width']; ?>" />
	            </p>

	            <p><label><?php _e( 'Width', 'magazine-premium' ); ?></label><br />
	            <select name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][width]">
	            	<option value="c2"<?php selected( $afp_section['width'], 'c2'); ?>>17%</option>
	            	<option value="c3"<?php selected( $afp_section['width'], 'c3'); ?>>25%</option>
	            	<option value="c4"<?php selected( $afp_section['width'], 'c4'); ?>>34%</option>
	            	<option value="c5"<?php selected( $afp_section['width'], 'c5'); ?>>42%</option>
	            	<option value="c6"<?php selected( $afp_section['width'], 'c6'); ?>>50%</option>
	            	<option value="c7"<?php selected( $afp_section['width'], 'c7'); ?>>58%</option>
	            	<option value="c8"<?php selected( $afp_section['width'], 'c8'); ?>>66%</option>
	            	<option value="c9"<?php selected( $afp_section['width'], 'c9'); ?>>75%</option>
	            	<option value="c10"<?php selected( $afp_section['width'], 'c10'); ?>>83%</option>
	            	<option value="c12"<?php selected( $afp_section['width'], 'c12'); ?>>100%</option>
	            </select>
	            </p>

	            <p>
	            <input type="radio" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][excerpt_content]" value="excerpt"<?php checked( $afp_section['excerpt_content'], 'excerpt' ); ?> /> <label><?php _e( 'Excerpt', 'magazine-premium' ); ?></label>
	            &nbsp;&nbsp;
	            <input type="radio" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][excerpt_content]" value="content"<?php checked( $afp_section['excerpt_content'], 'content' ); ?> /> <label><?php _e( 'Content', 'magazine-premium' ); ?></label>
	            </p>

	            <p><label><?php _e( 'Excerpt Length', 'magazine-premium' ); ?></label><br />
	            <input type="text" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][excerpt_length]" value="<?php echo $afp_section['excerpt_length']; ?>" />
	            </p>

	            <p><label><?php _e( 'Columns', 'magazine-premium' ); ?></label><br />
	            <select name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][columns]">
	            	<option value="c12"<?php selected( $afp_section['columns'], 'c12'); ?>><?php _e( '1 Column', 'magazine-premium' ) ?></option>
	            	<option value="c6"<?php selected( $afp_section['columns'], 'c6'); ?>><?php _e( '2 Columns', 'magazine-premium' ) ?></option>
	            	<option value="c4"<?php selected( $afp_section['columns'], 'c4'); ?>><?php _e( '3 Columns', 'magazine-premium' ) ?></option>
	            	<option value="c3"<?php selected( $afp_section['columns'], 'c3'); ?>><?php _e( '4 Columns', 'magazine-premium' ) ?></option>
	            	<option value="c2"<?php selected( $afp_section['columns'], 'c2'); ?>><?php _e( '6 Columns', 'magazine-premium' ) ?></option>
	            </select>
	            </p>

	            <p><label><?php _e( 'Number of Posts', 'magazine-premium' ); ?></label><br />
	            <input type="text" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][number]" value="<?php echo $afp_section['number']; ?>" />
	            </p>

	            <p><label><?php _e( 'Offset', 'magazine-premium' ); ?></label><br />
	            <input type="text" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][offset]" value="<?php echo $afp_section['offset']; ?>" />
	            </p>

	            <p><label><?php _e( 'Border', 'magazine-premium' ); ?></label><br />
	            <select name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][border]">
	            	<option value=""<?php selected( $afp_section['border'], ''); ?>><?php _e( 'None', 'magazine-premium' ) ?></option>
	            	<option value="border-left"<?php selected( $afp_section['border'], 'border-left'); ?>><?php _e( 'Left', 'magazine-premium' ) ?></option>
	            	<option value="border-right"<?php selected( $afp_section['border'], 'border-right'); ?>><?php _e( 'Right', 'magazine-premium' ) ?></option>
	            </select>
	            </p>

	            <p><input type="checkbox" name="mp_advanced_front_page[<?php echo $section; ?>][<?php echo $count; ?>][separator]"<?php checked( $afp_section['separator'], 'on' ); ?> /> <label><?php _e( 'Top Separator', 'magazine-premium' ); ?></label>
	            </p>
            </div>
            <?php
	         $count++;
		}
	}

	/**
	 * Ajax function to add new section
	 *
	 * @since 2.0.0
	 */
	public function add_new_section() {
		$arr = array(
			'title' => '',
			'category' => '',
			'width' => 'c12',
			'columns' => 'c12',
			'offset' => '',
			'number' => 5,
			'border' => '',
			'separator' => '',
			'image_alignment' => 'alignleft',
			'image_width' => '200',
			'excerpt_content' => 'excerpt',
			'excerpt_length' => '55',
			'link' => ''
		);
		$advanced_front_page = get_option( 'mp_advanced_front_page' );
		$type = ( isset( $_POST['type'] ) ) ? $_POST['type'] : 'upper';
		$advanced_front_page[$type] = ( isset( $advanced_front_page[$type] ) ) ? $advanced_front_page[$type] : array();

		if ( $advanced_front_page )
			array_push( $advanced_front_page[$type], $arr );
		else
			$advanced_front_page[$type] = array( $arr );

		update_option( 'mp_advanced_front_page', $advanced_front_page );
		echo 1;
		die();
	}

	/**
	 * Ajax function to delete section
	 *
	 * @since 2.0.0
	 */
	public function delete_section() {
		$advanced_front_page = get_option( 'mp_advanced_front_page' );
		$section_id = (int) $_POST['section_id'];
		$type = ( isset( $_POST['type'] ) ) ? $_POST['type'] : 'upper';
		array_splice( $advanced_front_page[$type], $section_id, 1 );
		update_option( 'mp_advanced_front_page', $advanced_front_page );
		echo 1;
		die();
	}
}
$bavotasan_advanced_front_page = new Bavotasan_Advanced_Front_Page;

/**
 * Display the advanced front page
 *
 * @param	string $advanced_front_page  Either 'upper' or 'lower'
 *
 * @return	Advanced page sections on the front end
 * @since 2.0.0
 */
function advanced_front_page( $advanced_front_page, $place = null ) {
	?>
	<div class="advanced-front-page row">
		<?php
		$count = 1;
		foreach ( $advanced_front_page as $afp_section ) {
			$afp_posts = new WP_Query( array(
				'posts_per_page' => $afp_section['number'],
				'cat' => $afp_section['category'],
				'offset' => $afp_section['offset'],
				'post__not_in' => get_option( 'sticky_posts' ),
			) );
			$separator = ( ! empty( $afp_section['separator'] ) ) ? '<div class="top-separator"></div>' : '';
			$title = ( isset( $afp_section['link'] ) ) ? '<a href="' . esc_url( get_category_link( $afp_section['category'] ) ) . '">' . __( $afp_section['title'], 'magazine-premium' ) . ' <i class="icon-circle-arrow-right"></i></a>' : __( $afp_section['title'], 'magazine-premium' );
			?>
			<div id="<?php echo $place; ?>-section-<?php echo $count; ?>" class="section <?php echo $afp_section['width'] . ' ' . $afp_section['border']; ?>">
				<?php
				echo $separator;
				if ( $afp_section['title'] ) { ?>
				<h1 class="page-title"><?php echo $title; ?></h1>
				<?php } ?>
				<div class="row columns-<?php echo $afp_section['columns']; ?>">
					<?php
				    while ( $afp_posts->have_posts() ) : $afp_posts->the_post();
				    	global $mp_afp_columns;
				    	$mp_afp_columns = array(
				    		'columns' => $afp_section['columns'],
				    		'count' => $afp_posts->current_post,
				    		'image_alignment' => $afp_section['image_alignment'],
				    		'image_width' => $afp_section['image_width'],
				    		'excerpt_content' => $afp_section['excerpt_content'],
				    		'excerpt_length' => $afp_section['excerpt_length'],
				    	);

   				    	global $mp_content_area;
   				    	$mp_content_area = 'main';
				    	get_template_part( 'content', get_post_format() );
					endwhile;
					?>
				</div>
			</div>
			<?php
			wp_reset_postdata();
			$count++;
		}
		?>
	</div>
	<?php
}

/**
 * Create the required attributes for the #lower-index main content
 *
 * @since 2.0.0
 */
function mp_lower_index_attr() {
	$advanced_front_page = get_option( 'mp_advanced_front_page' );

	$end = ( 'left' == $advanced_front_page['lower_content_alignment'] ) ? ' end' : '';
	$class = $advanced_front_page['lower_content_width'];

	echo 'class="' . $class . $end . '"';
}

/**
 * Create the required classes for the #lower-index container sidebar
 *
 * @since 2.0.0
 */
function mp_lower_index_sidebar_class() {
	$advanced_front_page = get_option( 'mp_advanced_front_page' );

	$end = ( 'right' == $advanced_front_page['lower_content_alignment'] ) ? ' end' : '';
	$class = str_replace( 'c', '', $advanced_front_page['lower_content_width'] );
	$class = 'c' . ( 12 - $class );

	echo 'class="' . $class . $end . '"';
}