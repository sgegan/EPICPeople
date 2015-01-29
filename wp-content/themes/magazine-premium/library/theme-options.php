<?php
/**
 * Set up the default theme options
 *
 * @since 2.0.0
 */
function mp_theme_options() {
	//delete_option( 'mp_theme_options' );
	$default_theme_options = array(
		'width' => '',
		'layout' => '2',
		'primary' => 'c8',
		'secondary' => 'c2',
		'tagline' => 'on',
		'display_author' => 'on',
		'display_date' => 'on',
		'display_comment_count' => '',
		'display_categories' => '',
		'excerpt_content' => 'excerpt',
		'page_background_color' => '#ffffff',
		'grid' => '3',
		'number' => '6',
		'link_color' => '#0089C4',
		'link_hover_color' => '#222222',
		'main_text_color' => '#444444',
		'nav_text_color' => '#eeeeee',
		'nav_text_hover_color' => '#eeeeee',
		'nav_background_color' => '#272727',
		'nav_background_hover_color' => '#111111',
		'nav_font' => 'PT Sans, sans-serif',
		'nav_font_size' => '15',
		'sub_nav_font_size' => '12',
		'headers_color' => '#222222',
		'read_more' => 'Read more &rarr;',
		'extended_footer_columns' => 'c4',
		'logo' => '',
		'copyright' => 'Copyright &copy; ' . date( 'Y' ) . ' <a href="' . home_url() . '">' . get_bloginfo( 'name' ) .'</a>. All Rights Reserved.',
		'main_text_font' => 'PT Sans, sans-serif',
		'main_text_font_size' => '14',
		'headers_font' => 'Arvo Bold, serif',
		'site_title_font' => 'Quattrocento, serif',
		'site_title_font_size' => '48',
		'site_description_font' => 'Raleway, cursive',
		'site_description_font_size' => '16',
		'post_title_font' => 'Lato, sans-serif',
		'post_title_font_size' => '28',
		'post_meta_font' => 'Lato Light, sans-serif',
		'post_meta_font_size' => '12',
		'post_category_font' => 'Lato Light, sans-serif',
		'post_category_font_size' => '12',
		'header_alignment' => 'fl',
		'1_image_width' => '560',
		'2_image_width' => '260',
		'3_image_width' => '160',
		'image_bar_category' => '0',
		'image_bar_columns' => 'c2',
		'image_bar_display' => 'on',
		'read_more_text_color' => '#ffffff',
		'read_more_background_color' => '#444444',
		'sidebar_background_color' => '#F6F6F6',
	);

	$theme_options = get_option( 'mp_theme_options', $default_theme_options );

	return $theme_options;
}

add_action( 'customize_register', 'hint_customizer' ,10,1);
/**
 * Add Text class for adding hints to theme customizer
 *
 * @since 2.0.0
 */
function hint_customizer() {
	class Custom_Text_Control extends WP_Customize_Control {
	    public $text = ''; // we add this for the extra description
	    public function render_content() {
	    ?>
	    <label><?php echo esc_html( $this->text ); ?></label>
	    <?php
	    }
	}
}

class Bavotasan_Customizer {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_sidebar' ) );
	}

	/**
	 * Add a 'Theme Options' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'customize_theme', 'title' => __( 'Theme Options', 'magazine-premium' ), 'href' => admin_url( 'customize.php' ) ) );
	}

	/**
	 * Add a 'customize' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( __( 'Theme Options', 'magazine-premium' ), __( 'Theme Options', 'magazine-premium' ), 'edit_theme_options', 'customize.php', '' );
	}

	/**
	 * Adds theme options to the Customizer screen
	 *
	 * This function is attached to the 'customize_register' action hook.
	 *
	 * @param	class $wp_customize
	 *
	 * @since 1.0.0
	 */
	public function customize_register( $wp_customize ) {
		$bavotasan_theme_options = mp_theme_options();
		$advanced_front_page = get_option( 'mp_advanced_front_page' );

		$wp_customize->add_setting( 'mp_theme_options[tagline]', array(
			'default' => $bavotasan_theme_options['tagline'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_tagline', array(
			'label' => __( 'Display Tagline', 'magazine-premium' ),
			'section' => 'title_tagline',
			'settings' => 'mp_theme_options[tagline]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'mp_theme_options[logo]', array(
			'default' => $bavotasan_theme_options['logo'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			'label' => __( 'Site Logo', 'magazine-premium' ),
			'section' => 'title_tagline',
			'settings' => 'mp_theme_options[logo]',
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[header_alignment]', array(
			'default' => $bavotasan_theme_options['header_alignment'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_header_alignment', array(
			'label' => __( 'Header Alignment', 'magazine-premium' ),
			'section' => 'title_tagline',
			'settings' => 'mp_theme_options[header_alignment]',
			'type' => 'select',
			'choices' => array(
				'fl' => __( 'Left', 'magazine-premium' ),
				'fr' => __( 'Right', 'magazine-premium' ),
				'center' => __( 'Center', 'magazine-premium' ),
			),
		) );

		// Layout section panel
		$wp_customize->add_section( 'mp_layout', array(
			'title' => __( 'Layout', 'magazine-premium' ),
			'priority' => 35,
		) );

		$wp_customize->add_setting( 'mp_theme_options[width]', array(
			'default' => $bavotasan_theme_options['width'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_width', array(
			'label' => __( 'Site Width', 'magazine-premium' ),
			'section' => 'mp_layout',
			'settings' => 'mp_theme_options[width]',
			'priority' => 10,
			'type' => 'select',
			'choices' => array(
				'' => '1200px',
				'w960' => __( '960px', 'magazine-premium' ),
				'w640' => __( '640px', 'magazine-premium' ),
				'wfull' => __( 'Full Width', 'magazine-premium' ),
			),
		) );

		$wp_customize->add_setting( 'mp_theme_options[layout]', array(
			'default' => $bavotasan_theme_options['layout'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_site_layout', array(
			'label' => __( 'Site Layout', 'magazine-premium' ),
			'section' => 'mp_layout',
			'settings' => 'mp_theme_options[layout]',
			'priority' => 15,
			'type' => 'radio',
			'choices' => array(
				'1' => __( '1 Sidebar - Left', 'magazine-premium' ),
				'2' => __( '1 Sidebar - Right', 'magazine-premium' ),
				'3' => __( '2 Sidebars - Left', 'magazine-premium' ),
				'4' => __( '2 Sidebars - Right', 'magazine-premium' ),
				'5' => __( '2 Sidebars - Separate', 'magazine-premium' ),
				'6' => __( 'No Sidebars', 'magazine-premium' )
			),
		) );

		$choices =  array(
			'c2' => '17%',
			'c3' => '25%',
			'c4' => '34%',
			'c5' => '42%',
			'c6' => '50%',
			'c7' => '58%',
			'c8' => '66%',
			'c9' => '75%',
			'c10' => '83%',
			'c12' => '100%',
		);

		$wp_customize->add_setting( 'mp_theme_options[primary]', array(
			'default' => $bavotasan_theme_options['primary'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_primary_column', array(
			'label' => __( 'Main Content', 'magazine-premium' ),
			'section' => 'mp_layout',
			'settings' => 'mp_theme_options[primary]',
			'priority' => 20,
			'type' => 'select',
			'choices' => $choices,
		) );

		$wp_customize->add_setting( 'mp_theme_options[secondary]', array(
			'default' => $bavotasan_theme_options['secondary'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_secondary_column', array(
			'label' => __( 'First Sidebar', 'magazine-premium' ),
			'section' => 'mp_layout',
			'settings' => 'mp_theme_options[secondary]',
			'priority' => 25,
			'type' => 'select',
			'choices' => $choices,
		) );

		$wp_customize->add_setting( 'mp_theme_options[read_more]', array(
			'default' => $bavotasan_theme_options['read_more'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_read_more', array(
			'label' => __( '"Read More" Text', 'magazine-premium' ),
			'section' => 'mp_layout',
			'settings' => 'mp_theme_options[read_more]',
			'priority' => 33,
			'type' => 'text',
		) );

		// Front Page
		$wp_customize->add_section( 'mp_front_page', array(
			'title' => __( 'Basic Front Page', 'magazine-premium' ),
			'priority' => 40,
		) );

	    $wp_customize->add_setting( 'mp_theme_options[basic_text]' );

	    $wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'basic_text', array(
			'section' => 'mp_front_page',
	        'settings' => 'mp_theme_options[basic_text]',
	        'text' => __( 'These settings only work if you haven\'t added sections to the Advanced Front Page.', 'magazine-premium' ),
			'priority' => 1,
	        ) )
	    );

		$wp_customize->add_setting( 'mp_theme_options[excerpt_content]', array(
			'default' => $bavotasan_theme_options['excerpt_content'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_front_page_excerpt_content', array(
			'label' => __( 'Post Content Display', 'magazine-premium' ),
			'section' => 'mp_front_page',
			'settings' => 'mp_theme_options[excerpt_content]',
			'type' => 'radio',
			'choices' => array(
				'excerpt' => __( 'Teaser Excerpt', 'magazine-premium' ),
				'content' => __( 'Full Content', 'magazine-premium' ),
			),
		) );

		$wp_customize->add_setting( 'mp_theme_options[grid]', array(
			'default' => $bavotasan_theme_options['grid'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_front_page_grid', array(
			'label' => __( 'Grid Layout', 'magazine-premium' ),
			'section' => 'mp_front_page',
			'settings' => 'mp_theme_options[grid]',
			'type' => 'radio',
			'choices' => array(
				'1' => __( 'Single', 'magazine-premium' ),
				'2' => __( 'Single - Two Columns', 'magazine-premium' ),
				'3' => __( 'Single - Two Columns - Three Columns', 'magazine-premium' ),
				'4' => __( 'Single - Three Columns', 'magazine-premium' ),
			),
		) );

		$wp_customize->add_setting( 'mp_theme_options[number]', array(
			'default' => $bavotasan_theme_options['number'],
			'type' => 'option',
			'sanitize_callback' => array( $this, 'mp_sanitize_int' ),
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_front_page_number', array(
			'label' => __( 'Number of Posts', 'magazine-premium' ),
			'section' => 'mp_front_page',
			'settings' => 'mp_theme_options[number]',
		) );

		$wp_customize->add_setting( 'mp_theme_options[1_image_width]', array(
			'default' => $bavotasan_theme_options['1_image_width'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'mp_sanitize_int' ),
		) );

		$wp_customize->add_control( 'mp_front_page_1_image_width', array(
			'label' => __( '1 Column Image Width (pixels)', 'magazine-premium' ),
			'section' => 'mp_front_page',
			'settings' => 'mp_theme_options[1_image_width]',
			'priority' => 60,
		) );

		$wp_customize->add_setting( 'mp_theme_options[2_image_width]', array(
			'default' => $bavotasan_theme_options['2_image_width'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'mp_sanitize_int' ),
		) );

		$wp_customize->add_control( 'mp_front_page_2_image_width', array(
			'label' => __( '2 Column Image Width (pixels)', 'magazine-premium' ),
			'section' => 'mp_front_page',
			'settings' => 'mp_theme_options[2_image_width]',
			'priority' => 70,
		) );

		$wp_customize->add_setting( 'mp_theme_options[3_image_width]', array(
			'default' => $bavotasan_theme_options['3_image_width'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => array( $this, 'mp_sanitize_int' ),
		) );

		$wp_customize->add_control( 'mp_front_page_3_image_width', array(
			'label' => __( '3 Column Image Width (pixels)', 'magazine-premium' ),
			'section' => 'mp_front_page',
			'settings' => 'mp_theme_options[3_image_width]',
			'priority' => 80,
		) );

		// Advanced Front Page
		$wp_customize->add_section( 'mp_advanced_front_page', array(
			'title' => __( 'Advanced Front Page', 'magazine-premium' ),
			'priority' => 45,
		) );

	    $wp_customize->add_setting( 'mp_theme_options[text]' );

	    $wp_customize->add_control( new Custom_Text_Control( $wp_customize, 'text', array(
			'section' => 'mp_advanced_front_page',
	        'settings' => 'mp_theme_options[text]',
	        'text' => __( 'Go to the Advanced Front Page admin page for more options.', 'magazine-premium' )
	        ) )
	    );

		$wp_customize->add_setting( 'mp_advanced_front_page[lower_content_width]', array(
			'default' => $advanced_front_page['lower_content_width'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_lower_content_width', array(
			'label' => __( 'Lower Content Width', 'magazine-premium' ),
			'section' => 'mp_advanced_front_page',
			'settings' => 'mp_advanced_front_page[lower_content_width]',
			'type' => 'select',
			'choices' => $choices,
		) );

		$wp_customize->add_setting( 'mp_advanced_front_page[lower_content_alignment]', array(
			'default' => $advanced_front_page['lower_content_alignment'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_lower_content_alignment', array(
			'label' => __( 'Lower Sidebar Position', 'magazine-premium' ),
			'section' => 'mp_advanced_front_page',
			'settings' => 'mp_advanced_front_page[lower_content_alignment]',
			'type' => 'select',
			'choices' => array(
				'left' => __( 'Left', 'magazine-premium' ),
				'right' => __( 'Right', 'magazine-premium' ),
			),
		) );

		// Fonts panel
		$mixed_fonts = array_merge( mp_websafe_fonts() , mp_google_fonts() );
		asort( $mixed_fonts );

		$wp_customize->add_section( 'mp_fonts', array(
			'title' => __( 'Fonts', 'magazine-premium' ),
			'priority' => 50,
		) );

		$wp_customize->add_setting( 'mp_theme_options[main_text_font]', array(
			'default' => $bavotasan_theme_options['main_text_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_main_text_font', array(
			'label' => __( 'Main Text', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[main_text_font]',
			'priority' => 10,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[main_text_font_size]', array(
			'default' => $bavotasan_theme_options['main_text_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_main_text_font_size', array(
			'label' => __( 'Main Text Size (in pixels)', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[main_text_font_size]',
			'priority' => 11,
		) );

		$wp_customize->add_setting( 'mp_theme_options[headers_font]', array(
			'default' => $bavotasan_theme_options['headers_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_headers_font', array(
			'label' => __( 'Headers (h1, h2, h3, etc...)', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[headers_font]',
			'priority' => 15,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[site_title_font]', array(
			'default' => $bavotasan_theme_options['site_title_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_site_title_font', array(
			'label' => __( 'Site Title', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[site_title_font]',
			'priority' => 20,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[site_title_font_size]', array(
			'default' => $bavotasan_theme_options['site_title_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_site_title_font_size', array(
			'label' => __( 'Site Title Size (in pixels)', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[site_title_font_size]',
			'priority' => 21,
		) );

		$wp_customize->add_setting( 'mp_theme_options[site_description_font]', array(
			'default' => $bavotasan_theme_options['site_description_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_site_description_font', array(
			'label' => __( 'Site Description', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[site_description_font]',
			'priority' => 25,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[site_description_font_size]', array(
			'default' => $bavotasan_theme_options['site_description_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_site_description_font_size', array(
			'label' => __( 'Site Description Size (in pixels)', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[site_description_font_size]',
			'priority' => 26,
		) );

		$wp_customize->add_setting( 'mp_theme_options[post_title_font]', array(
			'default' => $bavotasan_theme_options['post_title_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_post_title_font', array(
			'label' => __( 'Post Title', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[post_title_font]',
			'priority' => 30,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[post_title_font_size]', array(
			'default' => $bavotasan_theme_options['post_title_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_post_title_font_size', array(
			'label' => __( 'Post Title Size (in pixels)', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[post_title_font_size]',
			'priority' => 31,
		) );

		$wp_customize->add_setting( 'mp_theme_options[post_meta_font]', array(
			'default' => $bavotasan_theme_options['post_meta_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_meta_font', array(
			'label' => __( 'Post Meta', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[post_meta_font]',
			'priority' => 35,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[post_meta_font_size]', array(
			'default' => $bavotasan_theme_options['post_meta_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_post_meta_font_size', array(
			'label' => __( 'Post Meta Size (in pixels)', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[post_meta_font_size]',
			'priority' => 36,
		) );

		$wp_customize->add_setting( 'mp_theme_options[post_category_font]', array(
			'default' => $bavotasan_theme_options['post_category_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_post_category_font', array(
			'label' => __( 'Post Category', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[post_category_font]',
			'priority' => 40,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[post_category_font_size]', array(
			'default' => $bavotasan_theme_options['post_category_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_post_category_font_size', array(
			'label' => __( 'Post Category Size (in pixels)', 'magazine-premium' ),
			'section' => 'mp_fonts',
			'settings' => 'mp_theme_options[post_category_font_size]',
			'priority' => 41,
		) );

		// Color panel
		$wp_customize->add_setting( 'mp_theme_options[page_background_color]', array(
			'default' => $bavotasan_theme_options['page_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_background_color', array(
			'label' => __( 'Page Background Color', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[page_background_color]',
			'priority' => 11,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[headers_color]', array(
			'default' => $bavotasan_theme_options['headers_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headers_color', array(
			'label' => __( 'Headers (h1, h2, h3, etc...)', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[headers_color]',
			'priority' => 20,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[main_text_color]', array(
			'default' => $bavotasan_theme_options['main_text_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_text_color', array(
			'label' => __( 'Main Text Color', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[main_text_color]',
			'priority' => 25,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[link_color]', array(
			'default' => $bavotasan_theme_options['link_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
			'label' => __( 'Link Color', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[link_color]',
			'priority' => 50,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[link_hover_color]', array(
			'default' => $bavotasan_theme_options['link_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_hover_color', array(
			'label' => __( 'Link Hover Color', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[link_hover_color]',
			'priority' => 55,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[read_more_text_color]', array(
			'default' => $bavotasan_theme_options['read_more_text_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'read_more_text_color', array(
			'label' => __( 'Read More Text Color', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[read_more_text_color]',
			'priority' => 60,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[read_more_background_color]', array(
			'default' => $bavotasan_theme_options['read_more_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'read_more_background_color', array(
			'label' => __( 'Read More Background Color', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[read_more_background_color]',
			'priority' => 65,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[sidebar_background_color]', array(
			'default' => $bavotasan_theme_options['sidebar_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_background_color', array(
			'label' => __( 'Sidebar Background Color', 'magazine-premium' ),
			'section'  => 'colors',
			'settings' => 'mp_theme_options[sidebar_background_color]',
			'priority' => 70,
		) ) );

		// Nav panel
		$wp_customize->add_setting( 'mp_theme_options[nav_text_color]', array(
			'default' => $bavotasan_theme_options['nav_text_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_text_color', array(
			'label' => __( 'Nav Text Color', 'magazine-premium' ),
			'section'  => 'nav',
			'settings' => 'mp_theme_options[nav_text_color]',
			'priority' => 1,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[nav_text_hover_color]', array(
			'default' => $bavotasan_theme_options['nav_text_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_text_hover_color', array(
			'label' => __( 'Nav Text Hover Color', 'magazine-premium' ),
			'section'  => 'nav',
			'settings' => 'mp_theme_options[nav_text_hover_color]',
			'priority' => 2,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[nav_background_color]', array(
			'default' => $bavotasan_theme_options['nav_background_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_background_color', array(
			'label' => __( 'Nav Background Color', 'magazine-premium' ),
			'section'  => 'nav',
			'settings' => 'mp_theme_options[nav_background_color]',
			'priority' => 3,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[nav_background_hover_color]', array(
			'default' => $bavotasan_theme_options['nav_background_hover_color'],
			'type' => 'option',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'nav_background_hover_color', array(
			'label' => __( 'Nav Background Hover Color', 'magazine-premium' ),
			'section'  => 'nav',
			'settings' => 'mp_theme_options[nav_background_hover_color]',
			'priority' => 4,
		) ) );

		$wp_customize->add_setting( 'mp_theme_options[nav_font]', array(
			'default' => $bavotasan_theme_options['nav_font'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_nav_font', array(
			'label' => __( 'Nav Text', 'magazine-premium' ),
			'section' => 'nav',
			'settings' => 'mp_theme_options[nav_font]',
			'priority' => 5,
			'type' => 'select',
			'choices' => $mixed_fonts,
		) );

		$wp_customize->add_setting( 'mp_theme_options[nav_font_size]', array(
			'default' => $bavotasan_theme_options['nav_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_nav_font_size', array(
			'label' => __( 'Primary Nav Text Size (in pixels)', 'magazine-premium' ),
			'section' => 'nav',
			'settings' => 'mp_theme_options[nav_font_size]',
			'priority' => 6,
		) );

		$wp_customize->add_setting( 'mp_theme_options[sub_nav_font_size]', array(
			'default' => $bavotasan_theme_options['sub_nav_font_size'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_sub_nav_font_size', array(
			'label' => __( 'Secondary Nav Text Size (in pixels)', 'magazine-premium' ),
			'section' => 'nav',
			'settings' => 'mp_theme_options[sub_nav_font_size]',
			'priority' => 7,
		) );

		// Posts panel
		$wp_customize->add_section( 'mp_posts', array(
			'title' => __( 'Posts', 'magazine-premium' ),
			'priority' => 45,
		) );

		$wp_customize->add_setting( 'mp_theme_options[display_categories]', array(
			'default' => $bavotasan_theme_options['display_categories'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_display_categories', array(
			'label' => __( 'Display Categories', 'magazine-premium' ),
			'section' => 'mp_posts',
			'settings' => 'mp_theme_options[display_categories]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'mp_theme_options[display_author]', array(
			'default' => $bavotasan_theme_options['display_author'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_display_author', array(
			'label' => __( 'Display Author', 'magazine-premium' ),
			'section' => 'mp_posts',
			'settings' => 'mp_theme_options[display_author]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'mp_theme_options[display_date]', array(
			'default' => $bavotasan_theme_options['display_date'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_display_date', array(
			'label' => __( 'Display Date', 'magazine-premium' ),
			'section' => 'mp_posts',
			'settings' => 'mp_theme_options[display_date]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'mp_theme_options[display_comment_count]', array(
			'default' => $bavotasan_theme_options['display_comment_count'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_display_comment_count', array(
			'label' => __( 'Display Comment Count', 'magazine-premium' ),
			'section' => 'mp_posts',
			'settings' => 'mp_theme_options[display_comment_count]',
			'type' => 'checkbox',
		) );

		// Footer panel
		$wp_customize->add_section( 'mp_footer', array(
			'title' => __( 'Footer', 'magazine-premium' ),
			'priority' => 50,
		) );

		$wp_customize->add_setting( 'mp_theme_options[image_bar_display]', array(
			'default' => $bavotasan_theme_options['image_bar_display'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_image_bar_display', array(
			'label' => __( 'Display Image Bar', 'magazine-premium' ),
			'section' => 'mp_footer',
			'settings' => 'mp_theme_options[image_bar_display]',
			'type' => 'checkbox',
		) );

		$wp_customize->add_setting( 'mp_theme_options[image_bar_category]', array(
			'default' => $bavotasan_theme_options['image_bar_category'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
		) );

		$categories = get_categories();
		$cats = array();
		$cats[0] = __( 'All', 'magazine-premium' );
		foreach ( $categories as $category ) {
		    $cats[$category->term_id] = $category->name;
		}

		$wp_customize->add_control( 'mp_image_bar_category', array(
			'label' => __( 'Image Bar Category', 'magazine-premium' ),
			'section' => 'mp_footer',
			'settings' => 'mp_theme_options[image_bar_category]',
			'priority' => 10,
			'type' => 'select',
			'choices' => $cats,
		) );

		$wp_customize->add_setting( 'mp_theme_options[image_bar_columns]', array(
			'default' => $bavotasan_theme_options['image_bar_columns'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( 'mp_image_bar_columns', array(
			'label' => __( 'Image Bar Columns', 'magazine-premium' ),
			'section' => 'mp_footer',
			'settings' => 'mp_theme_options[image_bar_columns]',
			'priority' => 10,
			'type' => 'select',
			'choices' => array(
				'c4' => __( '3 Columns', 'magazine-premium' ),
				'c3' => __( '4 Columns', 'magazine-premium' ),
				'c2' => __( '6 Columns', 'magazine-premium' ),
			),
		) );

		$wp_customize->add_setting( 'mp_theme_options[extended_footer_columns]', array(
			'default' => $bavotasan_theme_options['extended_footer_columns'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( 'mp_extended_footer_columns', array(
			'label' => __( 'Extended Footer Columns', 'magazine-premium' ),
			'section' => 'mp_footer',
			'settings' => 'mp_theme_options[extended_footer_columns]',
			'priority' => 15,
			'type' => 'select',
			'choices' => array(
				'c12' => __( '1 Column', 'magazine-premium' ),
				'c6' => __( '2 Columns', 'magazine-premium' ),
				'c4' => __( '3 Columns', 'magazine-premium' ),
				'c3' => __( '4 Columns', 'magazine-premium' ),
				'c2' => __( '6 Columns', 'magazine-premium' ),
			),
		) );

		$wp_customize->add_setting( 'mp_theme_options[copyright]', array(
			'default' => $bavotasan_theme_options['copyright'],
			'type' => 'option',
			'capability' => 'edit_theme_options',
		) );

		$wp_customize->add_control( 'mp_copyright', array(
			'label' => __( 'Copyright Notice', 'magazine-premium' ),
			'section' => 'mp_footer',
			'settings' => 'mp_theme_options[copyright]',
			'priority' => 20,
		) );

		if ( $wp_customize->is_preview() && ! is_admin() )
			add_action( 'wp_footer', array( $this, 'mp_customize_preview' ), 21);
	}

	/**
	 * jQuery for Customizer screen
	 *
	 * @since 1.0.0
	 */
	public function mp_customize_preview() {
		?>
<script>
( function( $ ){
	wp.customize( 'mp_theme_options[image_bar_columns]', function( value ) {
		value.bind( function( to ) {
			var num = { 'c4' : 3, 'c3' : 4, 'c2' : 6 };
			$( '#image-bar' ).find( 'div' )
				.hide()
				.removeClass( 'c2 c3 c4 c6 c12' ).addClass( to )
				.slice( 0, num[to] ).show();
		} );
	} );
	wp.customize( 'mp_theme_options[extended_footer_columns]', function( value ) {
		value.bind( function( to ) {
			$( '.footer-widget' ).removeClass( 'c2 c3 c4 c6 c12' ).addClass( to );
		} );
	} );
} )( jQuery )
</script>
		<?php
	}

	/**
	 * Sanitize integers
	 *
	 * @since 2.0.0
	 */
	public function mp_sanitize_int( $int ) {
		if ( '' === $int )
			return '';

		return (int) $int;
	}

	/**
	 * jQuery for Customizer screen
	 *
	 * This function is attached to the 'customize_controls_print_footer_scripts' action hook.
	 *
	 * @since 1.0.0
	 */
	public function customize_sidebar() {
		?>
<script>
( function( $ ){
	var sl_el = $( '#customize-control-mp_site_layout' ).find( 'input' ),
		sl_value = sl_el.filter( ':checked' ).val(),
		sl_conditional_set = ( 3 == sl_value || 4 == sl_value || 5 == sl_value ),
		sl_id_set = $( '#customize-control-mp_secondary_column' );

	show_controls( sl_conditional_set, sl_id_set );
	sl_el.change(function() {
		var new_sl_value = sl_el.filter( ':checked' ).val();
		show_controls( 3 == new_sl_value || 4 == new_sl_value || 5 == new_sl_value, sl_id_set );
	});

	function show_controls( conditional, id ) {
		if ( conditional )
			id.show();
		else
			id.hide();
	}
} )( jQuery );
</script>
		<?php
	}
}
$bavotasan_customizer = new Bavotasan_Customizer;

/**
 * Prepare font CSS
 *
 * @param	string $font  The select font
 *
 * @since 1.0.0
 */
function mp_prepare_font( $font ) {
	$font_family = ( 'Lato Light, sans-serif' == $font ) ? 'Lato' : $font;
	$font_family = ( 'Arvo Bold, serif' == $font ) ? 'Arvo' : $font_family;
	$font_weight = ( 'Lato Light, sans-serif' == $font ) ? ' font-weight: 300' : 'font-weight: normal';
	$font_weight = ( 'Lato, sans-serif' == $font || 'Arvo Bold, serif' == $font ) ? ' font-weight: 900' : $font_weight;

	return 'font-family: ' . $font_family . '; ' . $font_weight;
}

if ( ! function_exists( 'mp_websafe_fonts' ) ) :
/**
 * Array of websafe fonts
 *
 * @return	Array of fonts
 *
 * @since 1.0.0
 */
function mp_websafe_fonts() {
    return array(
        'Arial, sans-serif' => 'Arial',
        '"Avant Garde", sans-serif' => 'Avant Garde',
        'Cambria, Georgia, serif' => 'Cambria',
        'Copse, sans-serif' => 'Copse',
        'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
        'Georgia, serif' => 'Georgia',
        '"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
        'Tahoma, Geneva, sans-serif' => 'Tahoma'
    );
}
endif;

if ( ! function_exists( 'mp_google_fonts' ) ) :
/**
 * Array of Google Fonts
 *
 * @return	Array of fonts
 *
 * @since 1.0.0
 */
function mp_google_fonts() {
    return array(
        'Arvo, serif' => 'Arvo *',
        'Arvo Bold, serif' => 'Arvo Bold *',
        'Copse, sans-serif' => 'Copse *',
        'Droid Sans, sans-serif' => 'Droid Sans *',
        'Droid Serif, serif' => 'Droid Serif *',
        'Exo, sans-serif' => 'Exo *',
        'Lato, sans-serif' => 'Lato *',
        'Lato Light, sans-serif' => 'Lato Light *',
        'Lobster, cursive' => 'Lobster *',
        'Nobile, sans-serif' => 'Nobile *',
        'Open Sans, sans-serif' => 'Open Sans *',
        'Oswald, sans-serif' => 'Oswald *',
        'Pacifico, cursive' => 'Pacifico *',
        'Raleway, cursive' => 'Raleway *',
        'Rokkitt, serif' => 'Rokkit *',
        'Russo One, sans-serif' => 'Russo One *',
        'PT Sans, sans-serif' => 'PT Sans *',
        'Quicksand, sans-serif' => 'Quicksand *',
        'Quattrocento, serif' => 'Quattrocento *',
        'Ubuntu, sans-serif' => 'Ubuntu *',
        'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz *'
    );
}
endif;