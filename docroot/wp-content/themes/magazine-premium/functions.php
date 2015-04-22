<?php
$bavotasan_theme_data = wp_get_theme();
define( 'MP_THEME_URL', get_template_directory_uri() );
define( 'MP_THEME_TEMPLATE', get_template_directory() );
define( 'BAVOTASAN_THEME_VERSION', trim( $bavotasan_theme_data->Version ) );
define( 'BAVOTASAN_THEME_NAME', $bavotasan_theme_data->Name );
define( 'BAVOTASAN_THEME_FILE', get_option( 'template' ) );
define( 'BAVOTASAN_THEME_CODE', 'map' );

/**
 * Includes
 *
 * @since 1.0.0
 */
require( MP_THEME_TEMPLATE . '/library/theme-options.php' ); // Functions for theme options page
require( MP_THEME_TEMPLATE . '/library/advanced-front-page.php' ); // Functions for advanced front page
require( MP_THEME_TEMPLATE . '/library/custom-css-editor.php' ); // Custom CSS editor
require( MP_THEME_TEMPLATE . '/library/custom-metaboxes.php' ); // Custom metaboxes added to post/page for full width option
require( MP_THEME_TEMPLATE . '/library/shortcodes.php' ); // Functions to add shortcodes
require( MP_THEME_TEMPLATE . '/library/slider.php' ); // Functions for the Slider page
require( MP_THEME_TEMPLATE . '/library/import-export.php' ); // Functions for the import/export page
require( MP_THEME_TEMPLATE . '/library/theme-updater.php' ); // Functions for update API
require( MP_THEME_TEMPLATE . '/library/pointers.php' ); // Functions for admin pointers

/**
 * Prepare the content width
 *
 * @since 2.0.4
 */
$bavotasan_theme_options = mp_theme_options();
$array_width = array( '' => 1200, 'w960' => 960, 'w640' => 640, 'w320' => 320, 'wfull' => 1200 );
$array_content = array( 'c2' => .17, 'c3' => .25, 'c4' => .34, 'c5' => .42, 'c6' => .5, 'c7' => .58, 'c8' => .66, 'c9' => .75, 'c10' => .83, 'c12' => 1 );
$bavotasan_main_content =  $array_content[$bavotasan_theme_options['primary']] * $array_width[$bavotasan_theme_options['width']] - 40;

if ( ! isset( $content_width ) )
	$content_width = $bavotasan_main_content;

add_action( 'after_setup_theme', 'mp_setup' );
if ( ! function_exists( 'mp_setup' ) ) :
/**
 * Initial setup for Magazine Basic theme
 *
 * This function is attached to the 'after_setup_theme' action hook.
 *
 * @uses	load_theme_textdomain()
 * @uses	get_locale()
 * @uses	add_theme_support()
 * @uses	add_editor_style()
 * @uses	register_default_headers()
 *
 * @since 2.0.0
 */
function mp_setup() {
	$bavotasan_theme_options = mp_theme_options();
	load_theme_textdomain( 'magazine-premium', MP_THEME_TEMPLATE . '/library/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menu( 'primary', __( 'Primary Menu', 'magazine-premium' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu', 'magazine-premium' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'audio', 'quote', 'link', 'status', 'aside', 'chat' ) );

	// This theme uses Featured Images (also known as post thumbnails) for archive pages
	add_theme_support( 'post-thumbnails' );
	add_image_size( '1_column', $bavotasan_theme_options['1_image_width'], 999 );
	add_image_size( '2_column', $bavotasan_theme_options['2_image_width'], 999 );
	add_image_size( '3_column', $bavotasan_theme_options['3_image_width'], 999 );
	add_image_size( 'image-bar-c4', 386, 290, true );
	add_image_size( 'image-bar-c3', 290, 218, true );
	add_image_size( 'image-bar-c2', 193, 145, true );

	// Add a filter to mp_header_image_width and mp_header_image_height to change the width and height of your custom header.
	add_theme_support( 'custom-header', array(
		'random-default' => true,
		'default-text-color' => '333',
		'flex-width' => true,
		'flex-height' => true,
		'width' => apply_filters( 'mp_header_image_width', 1200 ),
		'height' => apply_filters( 'mp_header_image_height', 300 ),
		'admin-head-callback' => 'mp_admin_header_style',
		'admin-preview-callback' => 'mp_admin_header_image'
	) );

	add_theme_support( 'custom-background', array(
		'default-image' => MP_THEME_URL . '/library/images/solid.png',
	) );}
endif; // mp_setup

if ( ! function_exists( 'mp_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in mp_setup().
 *
 * @since 2.0.0
 */
function mp_admin_header_style() {
	$text_color = get_header_textcolor();
	$styles = ( 'blank' == $text_color ) ? 'display:none' : 'color:#' . $text_color . ' !important';
	?>
<style>
.appearance_page_custom-header #headimg {
	border: none;
	}

#site-title {
	margin: 0;
	font-family: Georgia, sans-serif;
	font-size: 50px;
	line-height: 1.2;
	}

#site-description {
	font-family: Arial, sans-serif;
	margin: 0 0 30px;
	font-size: 20px;
	line-height: 1.2;
	font-weight: normal;
	padding: 0;
	}

#headimg img {
	max-width: 1200px;
	height: auto;
	width: 100%;
	}

#site-title,#site-description{<?php echo $styles; ?>}
</style>
	<?php
}
endif; // mp_admin_header_style

if ( ! function_exists( 'mp_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in mp_setup().
 *
 * @uses	bloginfo()
 * @uses	get_header_image()
 *
 * @since 2.0.0
 */
function mp_admin_header_image() {
	?>
	<div id="headimg">
		<h1 id="site-title"><?php bloginfo( 'name' ); ?></h1>
		<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		<?php if ( $header_image = get_header_image() ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
	<?php
}
endif; // mp_admin_header_image

add_action( 'wp_head', 'mp_styles' );
/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the 'wp_head' action hook.
 *
 * @since 1.0.0
 */
function mp_styles() {
	$text_color = get_header_textcolor();
	$styles = ( 'blank' == $text_color ) ? '' : 'color:#' . $text_color . ' !important';
	$bavotasan_theme_options = mp_theme_options();
	?>
<style>
body { color: <?php echo $bavotasan_theme_options['main_text_color']; ?>; <?php echo mp_prepare_font( $bavotasan_theme_options['main_text_font'] ); ?>; font-size: <?php echo $bavotasan_theme_options['main_text_font_size']; ?>px; }
#page { background-color: <?php echo $bavotasan_theme_options['page_background_color']; ?>; }
h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: <?php echo $bavotasan_theme_options['headers_color']; ?>; <?php echo mp_prepare_font( $bavotasan_theme_options['headers_font'] ); ?> }
#site-title a,#site-description{<?php echo $styles; ?>}
#site-title a { <?php echo mp_prepare_font( $bavotasan_theme_options['site_title_font'] ); ?>; font-size: <?php echo $bavotasan_theme_options['site_title_font_size']; ?>px; }
#site-description { <?php echo mp_prepare_font( $bavotasan_theme_options['site_description_font'] ); ?>; font-size: <?php echo $bavotasan_theme_options['site_description_font_size']; ?>px; }
#site-navigation, #site-sub-navigation { <?php echo mp_prepare_font( $bavotasan_theme_options['nav_font'] ); ?>; }
#site-navigation { font-size: <?php echo $bavotasan_theme_options['nav_font_size']; ?>px; background-color: <?php echo $bavotasan_theme_options['nav_background_color']; ?>; }
#site-navigation li:hover, #site-navigation ul ul { background-color: <?php echo $bavotasan_theme_options['nav_background_hover_color']; ?>; }
#site-navigation li a { color: <?php echo $bavotasan_theme_options['nav_text_color']; ?>; }
#site-navigation li a:hover { color: <?php echo $bavotasan_theme_options['nav_text_hover_color']; ?>; }
#site-sub-navigation { font-size: <?php echo $bavotasan_theme_options['sub_nav_font_size']; ?>px; }
a, .entry-meta a, .format-link .entry-title a { color: <?php echo $bavotasan_theme_options['link_color']; ?>; }
a:hover, .entry-meta a:hover, .format-link .entry-title a:hover { color: <?php echo $bavotasan_theme_options['link_hover_color']; ?>; }
.more-link, #posts-pagination a, input[type="submit"], .comment-reply-link, .more-link:hover, #posts-pagination a:hover, input[type="submit"]:hover, .comment-reply-link:hover { color: <?php echo $bavotasan_theme_options['read_more_text_color']; ?>; background-color: <?php echo $bavotasan_theme_options['none']; ?>; } /* read_more_background_color replaced by "none" */
.widget { background-color: <?php echo $bavotasan_theme_options['sidebar_background_color']; ?>; }
.entry-title, .entry-title a { <?php echo mp_prepare_font( $bavotasan_theme_options['post_title_font'] ); ?>; font-size: <?php echo $bavotasan_theme_options['post_title_font_size']; ?>px; }
.entry-meta, .entry-meta a { <?php echo mp_prepare_font( $bavotasan_theme_options['post_meta_font'] ); ?>; font-size: <?php echo $bavotasan_theme_options['post_meta_font_size']; ?>px; }
.post-category, .post-category a, .post-format, .post-format a { <?php echo mp_prepare_font( $bavotasan_theme_options['post_category_font'] ); ?>; font-size: <?php echo $bavotasan_theme_options['post_category_font_size']; ?>px; }
</style>
	<?php
}

add_action( 'admin_bar_menu', 'bavotasan_admin_bar_menu', 999 );
/**
 * Add menu item to toolbar
 *
 * This function is attached to the 'admin_bar_menu' action hook.
 *
 * @param	array $wp_admin_bar
 *
 * @since 2.0.4
 */
function bavotasan_admin_bar_menu( $wp_admin_bar ) {
    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() ) {
    	$wp_admin_bar->add_node( array( 'id' => 'bavotasan_toolbar', 'title' => BAVOTASAN_THEME_NAME, 'href' => admin_url( 'customize.php' ) ) );
    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'documentation_faqs', 'title' => __( 'Documentation & FAQs', 'magazine-premium' ), 'href' => 'https://themes.bavotasan.com/documentation', 'meta' => array( 'target' => '_blank' ) ) );

	}
}

add_action( 'pre_get_posts', 'mp_home_query' );
if ( ! function_exists( 'mp_home_query' ) ) :
/**
 * Remove sticky posts from home page query
 *
 * This function is attached to the 'pre_get_posts' action hook.
 *
 * @param	array $query
 *
 * @since 2.0.0
 */
function mp_home_query( $query = '' ) {
	$bavotasan_theme_options = mp_theme_options();

	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
		return;

	$query->set( 'post__not_in', (array) get_option( 'sticky_posts' ) );
	$query->set( 'posts_per_page', (int) $bavotasan_theme_options['number'] );
}
endif;

add_action( 'wp_enqueue_scripts', 'mp_add_js' );
if ( ! function_exists( 'mp_add_js' ) ) :
/**
 * Load all JavaScript to header
 *
 * This function is attached to the 'wp_enqueue_scripts' action hook.
 *
 * @uses	is_admin()
 * @uses	is_singular()
 * @uses	get_option()
 * @uses	wp_enqueue_script()
 * @uses	MP_THEME_URL
 *
 * @since 2.0.0
 */
function mp_add_js() {
	$bavotasan_theme_options = mp_theme_options();

	$var = array(
		'carousel' => false,
		'tooltip' => false,
		'tabs' => false
	);

	if ( is_singular() ) {
		if ( get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		global $post;
		$content = $post->post_content;
		if ( false !== strpos( $content, '[widetext' ) )
			wp_enqueue_script( 'widetext', MP_THEME_URL .'/library/js/widetext.min.js', array( 'jquery' ), '1.0.1', true );

		if ( false !== strpos( $content, '[carousel' ) )
			$var['carousel'] = true;

		if ( false !== strpos( $content, '[tooltip' ) )
			$var['tooltip'] = true;

		if ( false !== strpos( $content, '[tabs' ) )
			$var['tabs'] = true;
	}

	wp_enqueue_script( 'bootstrap', MP_THEME_URL .'/library/js/bootstrap.min.js', array( 'jquery' ), '2.2.2', true );
	wp_enqueue_script( 'harvey', MP_THEME_URL .'/library/js/harvey.min.js', '', '', true );

	if ( is_front_page() ) {
		$options = get_option( 'mp_slider_settings', array(
			'type' => 'scrollerota',
			'autoplay' => false,
			'interval' => 4000
		) );

		$var['type'] = $options['type'];
		$var['autoplay'] = $options['autoplay'];
		$var['interval'] = $options['interval'];

		if ( 'none' != $options['type'] )
			wp_enqueue_script( 'slider', MP_THEME_URL .'/library/js/slider.min.js', array( 'theme_js', 'jquery-effects-core' ), '', true );
	}

	wp_enqueue_script( 'theme_js', MP_THEME_URL .'/library/js/theme.js', array( 'bootstrap', 'harvey' ), '', true );
	wp_localize_script( 'theme_js', 'theme_js_vars', $var );

	// Fonts stuff
	$selected_fonts = array(
		$bavotasan_theme_options['main_text_font'],
		$bavotasan_theme_options['headers_font'],
		$bavotasan_theme_options['site_title_font'],
		$bavotasan_theme_options['site_description_font'],
		$bavotasan_theme_options['post_title_font'],
		$bavotasan_theme_options['post_meta_font'],
		$bavotasan_theme_options['post_category_font'],
	);
	$selected_fonts = array_unique( $selected_fonts );

	$google_fonts = mp_google_fonts();
	$font_string = '';
	foreach ( $selected_fonts as $font ) {
		if ( array_key_exists( $font, $google_fonts ) ) {
			$font = explode( ',', $font );
			$font = $font[0];
			switch( $font ) {
				case 'Open Sans':
					$font = 'Open+Sans:400,700';
					break;
				case 'Lato':
					$font = 'Lato:900';
					break;
				case 'Lato Light':
					$font = 'Lato:300';
					break;
				case 'Raleway':
					$font = 'Raleway:100';
					break;
				case 'Exo':
					$font = 'Exo:100';
					break;
				case 'Arvo Bold':
					$font = 'Arvo:900';
					break;
			}
			$font = str_replace( " ", "+", $font );
			$font_string .= $font . '|';
		}
	}

	if ( $font_string )
		wp_enqueue_style( 'google_fonts', '//fonts.googleapis.com/css?family=' . $font_string, false, null, 'all' );

	wp_enqueue_style( 'theme_stylesheet', get_stylesheet_uri() );
	wp_enqueue_style( 'font_awesome', '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css', false, null, 'all' );
}
endif; // mp_add_js

add_action( 'widgets_init', 'mp_widgets_init' );
if ( ! function_exists( 'mp_widgets_init' ) ) :
/**
 * Creating the two sidebars
 *
 * This function is attached to the 'widgets_init' action hook.
 *
 * @uses	register_sidebar()
 *
 * @since 2.0.0
 */
function mp_widgets_init() {
	$bavotasan_theme_options = mp_theme_options();

	require( MP_THEME_TEMPLATE . '/library/widgets/widget-feature.php' ); // Featured Posts widget
	require( MP_THEME_TEMPLATE . '/library/widgets/widget-authors.php' ); // List Authors widget

	register_sidebar( array(
		'name' => __( 'First Sidebar', 'magazine-premium' ),
		'id' => 'sidebar',
		'description' => __( 'This is the first sidebar area. All defaults widgets work great here.', 'magazine-premium' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Sidebar', 'magazine-premium' ),
		'id' => 'second-sidebar',
		'description' => __( 'This is the second sidebar area. All defaults widgets work great here. You must select one of the "2 sidebar" layout options in order to view this area on the front end.', 'magazine-premium' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Home Page Lower Sidebar', 'magazine-premium' ),
		'id' => 'lower-sidebar',
		'description' => __( 'This is the home page lower sidebar area. All defaults widgets work great here. You must add a widget to this sidebar in order to view this area on the front end.', 'magazine-premium' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Header Area', 'magazine-premium' ),
		'id' => 'header-area',
		'description' => __( 'Widgetized area in the header to the right of the site name. Great place for a search box or a banner ad.', 'magazine-premium' ),
		'before_widget' => '<aside id="%1$s" class="header-widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="header-widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Extended Footer', 'magazine-premium' ),
		'id' => 'extended-footer',
		'description' => __( 'This is the extended footer widgetized area. Widgets will appear in three columns. All defaults widgets work great here.', 'magazine-premium' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget ' . $bavotasan_theme_options['extended_footer_columns'] . ' %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
endif; // mp_widgets_init

if ( ! function_exists( 'mp_pagination' ) ) :
/**
 * Add pagination
 *
 * @uses	paginate_links()
 * @uses	add_query_arg()
 *
 * @since 2.0.0
 */
function mp_pagination() {
	global $wp_query;

	$current = max( 1, get_query_var('paged') );
	$big = 999999999; // need an unlikely integer

	$pagination_return = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => $current,
		'total' => $wp_query->max_num_pages,
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
	) );

	if ( ! empty( $pagination_return ) ) {
		echo '<div id="pagination">';
		echo '<div class="total-pages">';
		printf( __( 'Page %1$s of %2$s', 'magazine-premium' ), $current, $wp_query->max_num_pages );
		echo '</div>';
		echo $pagination_return;
		echo '</div>';
	}
}
endif; // mp_pagination

add_filter( 'wp_title', 'mp_filter_wp_title', 10, 2 );
if ( !function_exists( 'mp_filter_wp_title' ) ) :
/**
 * Filters the page title appropriately depending on the current page
 *
 * @uses	get_bloginfo()
 * @uses	is_home()
 * @uses	is_front_page()
 *
 * @since 2.0.0
 */
function mp_filter_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'magazine-premium' ), max( $paged, $page ) );

	return $title;
}
endif; // mp_filter_wp_title

if ( ! function_exists( 'mp_comment' ) ) :
/**
 * Callback function for comments
 *
 * Referenced via wp_list_comments() in comments.php.
 *
 * @uses	get_avatar()
 * @uses	get_comment_author_link()
 * @uses	get_comment_date()
 * @uses	get_comment_time()
 * @uses	edit_comment_link()
 * @uses	comment_text()
 * @uses	comments_open()
 * @uses	comment_reply_link()
 *
 * @since 2.0.0
 */
function mp_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case '' :
		?>
		<li <?php comment_class(); ?>>
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div>
				<div class="comment-content">
					<div class="comment-author">
						<?php echo get_comment_author_link() . ' '; ?>
					</div>
					<div class="comment-meta">
						<?php
						printf( __( '%1$s at %2$s', 'magazine-premium' ), get_comment_date(), get_comment_time() );
						edit_comment_link( __( '(edit)', 'magazine-premium' ), '  ', '' );
						?>
					</div>
					<div class="comment-text">
						<?php if ( '0' == $comment->comment_approved ) { echo '<em>' . __( 'Your comment is awaiting moderation.', 'magazine-premium' ) . '</em>'; } ?>
						<?php comment_text() ?>
					</div>
					<?php if ( $args['max_depth'] != $depth && comments_open() && 'pingback' != $comment->comment_type ) { ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php
			break;

		case 'pingback'  :
		case 'trackback' :
		?>
		<li id="comment-<?php comment_ID(); ?>" class="pingback">
			<div class="comment-body">
				<i class="icon-paper-clip"></i>
				<?php _e( 'Pingback:', 'magazine-premium' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(edit)', 'magazine-premium' ), ' ' ); ?>
			</div>
			<?php
			break;
	endswitch;
}
endif; // mp_comment

add_filter( 'comment_form_default_fields', 'mp_html5_fields' );
if ( ! function_exists( 'mp_html5_fields' ) ) :
/**
 * Adds HTML5 fields to comment form
 *
 * This function is attached to the 'comment_form_default_fields' filter hook.
 *
 * @param	array $fields
 *
 * @return	Modified comment form fields
 *
 * @since 2.0.0
 */
function mp_html5_fields( $fields ) {
	$fields['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" required size="30" placeholder="' . __( 'Name', 'magazine-premium' ) . ' *" aria-required="true" /></p>';
	$fields['email'] = '<p class="comment-form-email"><input id="email" name="email" type="email" required size="30" placeholder="' . __( 'Email', 'magazine-premium' ) . ' *" aria-required="true" /></p>';
	$fields['url'] = '<p class="comment-form-url"><input id="url" name="url" type="url" size="30" placeholder="' . __( 'Website', 'magazine-premium' ) . '" /></p>';

	return $fields;
}
endif; // mp_html5_fields

add_filter( 'get_search_form', 'mp_html5_search_form' );
if ( ! function_exists( 'mp_html5_search_form' ) ) :
/**
 * Update default WordPress search form to HTML5 search form
 *
 * This function is attached to the 'get_search_form' filter hook.
 *
 * @param	$form
 *
 * @return	Modified search form
 *
 * @since 2.0.0
 */
function mp_html5_search_form( $form ) {
    return '<form role="search" method="get" id="searchform" class="slide" action="' . home_url( '/' ) . '" >
    <label class="assistive-text" for="site-search">' . __('Search for:', 'magazine-premium') . '</label>
    <input type="search" placeholder="' . __( 'Search&hellip;', 'magazine-premium' ) . '" value="' . get_search_query() . '" name="s" id="site-search" />
    <button type="submit" class=" btn-default search-icon" img src="../magazine-premium-child/img/search-icon.png"></button>
    </form>';
}
endif; // mp_html5_search_form

add_filter( 'excerpt_more', 'mp_excerpt' );
if ( ! function_exists( 'mp_excerpt' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * This function is attached to the 'excerpt_more' filter hook.
 *
 * @param	int $more
 *
 * @return	Custom excerpt ending
 *
 * @since 2.0.0
 */
function mp_excerpt( $more ) {
	return '&hellip;';
}
endif; // mp_excerpt

add_filter( 'wp_trim_excerpt', 'mp_excerpt_more' );
if ( ! function_exists( 'mp_excerpt_more' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * This function is attached to the 'wp_trim_excerpt' filter hook.
 *
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 2.0.0
 */
function mp_excerpt_more( $text ) {
	$bavotasan_theme_options = mp_theme_options();
	return ( is_feed() ) ? $text : $text . '<p class="more-link-p"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( $bavotasan_theme_options['read_more'], 'magazine-premium' ) . '</a></p>';
}
endif; // mp_excerpt_more

add_filter( 'the_content_more_link', 'mp_content_more_link', 10, 2 );
if ( ! function_exists( 'mp_content_more_link' ) ) :
/**
 * Customize read more link for content
 *
 * This function is attached to the 'the_content_more_link' filter hook.
 *
 * @param	string $link
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 2.0.0
 */
function mp_content_more_link( $link, $text ) {
	return '<p class="more-link-p"><a class="more-link" href="' . get_permalink( get_the_ID() ) . '">' . $text . '</a></p>';
}
endif; // mp_content_more_link

add_filter( 'the_content', 'mp_headline', 10, 2 );
if ( ! function_exists( 'mp_headline' ) ) :
/**
 * Add the headline to the content.
 *
 * This function is attached to the 'the_content' filter hook.
 *
 * @param	string $content
 *
 * @return	Headline prepended to the content
 *
 * @since 2.0.2
 */
function mp_headline( $content ) {
	$headline = get_post_meta( get_the_ID(), 'mp_headline', true );
	return ( $headline && ! is_home() ) ? '<p class="headline">' . $headline . '</p>' . $content : $content;
}
endif; // mp_headline

add_filter( 'excerpt_length', 'mp_excerpt_length', 999 );
if ( ! function_exists( 'mp_excerpt_length' ) ) :
/**
 * Custom excerpt length
 *
 * This function is attached to the 'excerpt_length' filter hook.
 *
 * @param	int $length
 *
 * @return	Custom excerpt length
 *
 * @since 2.0.0
 */
function mp_excerpt_length( $length ) {
	global $bavotasan_custom_excerpt_length;

	if ( $bavotasan_custom_excerpt_length )
		return $bavotasan_custom_excerpt_length;
	else
		return 55;
}
endif; // mp_excerpt_length

/*
 * Remove default gallery styles
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Create the required attributes for the #primary container
 *
 * @since 2.0.0
 */
function mp_primary_attr() {
	$bavotasan_theme_options = mp_theme_options();

	$layout = $bavotasan_theme_options['layout'];
	$column = ( ! is_mp_full_width() ) ? $bavotasan_theme_options['primary'] : 'c12';
	$class = ( 6 == $layout ) ? $column . ' centered' : $column;
	$style = ( 1 == $layout || 3 == $layout ) ? ' style="float: right;"' : '';

	echo 'class="' . $class . '"' . $style;
}

/**
 * Create the required classes for the #secondary sidebar container
 *
 * @since 2.0.0
 */
function mp_sidebar_class() {
	$bavotasan_theme_options = mp_theme_options();

	$layout = $bavotasan_theme_options['layout'];
	if ( 1 == $layout || 2 == $layout || 6 == $layout ) {
		$end = ( 2 == $layout ) ? ' end' : '';
		$class = str_replace( 'c', '', $bavotasan_theme_options['primary'] );
		$class = 'c' . ( 12 - $class ) . $end;
	} else {
		$class = $bavotasan_theme_options['secondary'];
	}

	echo 'class="' . $class . '"';
}

/**
 * Create the required classes for the #tertiary sidebar container
 *
 * @since 2.0.0
 */
function mp_second_sidebar_class() {
	$bavotasan_theme_options = mp_theme_options();

	$layout = $bavotasan_theme_options['layout'];
	$end = ( 4 == $layout || 5 == $layout ) ? ' end' : '';
	$primary = str_replace( 'c', '', $bavotasan_theme_options['primary'] );
	$secondary = str_replace( 'c', '', $bavotasan_theme_options['secondary'] );
	$class = 'c' . ( 12 - $primary - $secondary ) . $end;

	echo 'class="' . $class . '"';
}

/**
 * Add class to sub-menu parent items
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 2.0.0
 */
class Bavotasan_Page_Navigation_Walker extends Walker_Nav_Menu {
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( !empty( $children_elements[ $element->$id_field ] ) )
            $element->classes[] = 'sub-menu-parent';

        Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}

add_filter( 'wp_nav_menu_args', 'bavotasan_nav_menu_args' );
/**
 * Set our new walker only if a menu is assigned and a child theme hasn't modified it to one level deep
 *
 * This function is attached to the 'wp_nav_menu_args' filter hook.
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 1.0.0
 */
function bavotasan_nav_menu_args( $args ) {
    if ( 1 !== $args[ 'depth' ] && has_nav_menu( 'primary' ) )
        $args[ 'walker' ] = new Bavotasan_Page_Navigation_Walker;

    return $args;
}

/**
 * Conditional check for basic home page layout
 *
 * @return	string class name
 *
 * @since 2.0.0
 */
function mp_home_page_class( $advanced = null ) {
	global $mp_content_area;
	$bavotasan_theme_options = mp_theme_options();
	$posts_per_page = $bavotasan_theme_options['number'];
	$lines = array(
		'c12' => 1,
		'c6' => 2,
		'c4' => 3,
		'c3' => 4,
		'c2' => 6,
	);

	if ( $advanced && 'sidebar' != $mp_content_area ) {
		$second_class = ( $lines[$advanced['columns']] <= $advanced['count'] ) ? ' top-border' : '';
		$class = $advanced['columns'] . $second_class;
	} else {
		$class = ( 'sidebar' == $mp_content_area ) ? 'c12' : '';
		if ( is_home() ) {
			global $wp_query;
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var('paged') : 1;
			$grid = $bavotasan_theme_options['grid'];
			$count = $wp_query->current_post;
			$class = 'c12 bottom-border';
			if ( 'sidebar' != $mp_content_area ) {
				if ( ( 2 == $grid || 3 == $grid ) && ( 0 < $count || 1 < $paged ) ) {
					$new_count = ( 1 == $paged ) ? $count - 1 : $count;
					$second_class = ( $lines['c6'] <= $new_count ) ? ' top-border' : '';
					$class = 'two-col c6' . $second_class;
				}
				if ( ( 3 == $grid && ( 2 < $count || 1 < $paged ) ) || ( 4 == $grid && ( 0 < $count || 1 < $paged ) ) ) {
					$count_array = array(
						4 => 1,
						3 => 3,
					);
					$new_count = ( 1 == $paged ) ? $count - $count_array[$grid] : $count;
					$second_class = ( $lines['c4'] <= $new_count ) ? ' top-border' : '';
					$class = 'three-col c4' . $second_class;
				}
			}
		}
	}
	return $class;
}

add_filter( 'body_class','bavotasan_custom_body_class' );
function bavotasan_custom_body_class( $classes ) {
	$bavotasan_theme_options = mp_theme_options();
	$arr = array( 1, 3, 5 );
	if ( in_array( $bavotasan_theme_options['layout'], $arr ) && ! is_mp_full_width() )
		$classes[] = 'left-sidebar';

	return $classes;
}

add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {
 return 'do.not.reply@epicpeople.org';
}
function new_mail_from_name($old) {
 return 'EPIC People';
}


//redirect author post archive to BP profile
add_action( 'template_redirect', 'themename_redirect_author_archive_to_profile' );
function themename_redirect_author_archive_to_profile() {
  if(is_author()){
    $user_id = get_query_var( 'author' );
    wp_redirect( bp_core_get_user_domain( $user_id ) );
  }
}
