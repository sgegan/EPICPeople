<?php
class Bavotasan_Tooltips {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'mp_pointers_header' ) );
	}

	/**
	 * Setting up the pointers array
	 *
	 * @since 1.0.0
	 *
	 * @return	array
	 */
	public function mp_pointers() {
		$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
		$prefix = BAVOTASAN_THEME_CODE . str_replace( '.', '', BAVOTASAN_THEME_VERSION ) . '_';

		$advanced_front_page_pointer_content = '<h3>' . __( 'Advanced Front Page', 'magazine-premium' ) . '</h3>';
		$advanced_front_page_pointer_content .= '<p>' . __( 'Customize your front page with a unique grid-style layout using the new Sections tool. Add as many new sections as you like!', 'magazine-premium' ) . '</p>';

		$slider_pointer_content = '<h3>' . __( 'Slider', 'magazine-premium' ) . '</h3>';
		$slider_pointer_content .= '<p>' . __( 'A home page slider is a great way to feature important posts or pages. Take a look at the brand new Slider admin page and choose from 4 different slider designs.', 'magazine-premium' ) . '</p>';

		$layout_options_pointer_content = '<h3>' . __( 'Full Width Option', 'magazine-premium' ) . '</h3>';
		$layout_options_pointer_content .= '<p>' . __( 'If you want this post/page to expand the full width of your site, check the box above and the sidebar(s) will be removed.', 'magazine-premium') . '</p>';

		$headline_pointer_content = '<h3>' . __( 'Headline', 'magazine-premium' ) . '</h3>';
		$headline_pointer_content .= '<p>' . __( 'Got something important to say? Then include it as a headline to make it stand out.', 'magazine-premium') . '</p>';

		return array(
			$prefix . 'advanced_front_page' => array(
				'content' => $advanced_front_page_pointer_content,
				'anchor_id' => '#wp-admin-bar-bavotasan_toolbar',
				'edge' => 'top',
				'align' => 'left',
				'active' => ( ! in_array( $prefix . 'advanced_front_page', $dismissed ) )
			),
			$prefix . 'slider' => array(
				'content' => $slider_pointer_content,
				'anchor_id' => '#menu-appearance',
				'edge' => 'left',
				'align' => 'center',
				'active' => ( ! in_array( $prefix . 'slider', $dismissed ) )
			),
			$prefix . 'layout_options' => array(
				'content' => $layout_options_pointer_content,
				'anchor_id' => '#theme-layout-options',
				'edge' => 'top',
				'align' => 'right',
				'active' => ( ! in_array( $prefix . 'layout_options', $dismissed ) )
			),
			$prefix . 'headline' => array(
				'content' => $headline_pointer_content,
				'anchor_id' => '#theme-headline',
				'edge' => 'top',
				'align' => 'right',
				'active' => ( ! in_array( $prefix . 'headline', $dismissed ) )
			),
		);
	}

	/**
	 * Pointers conditional check
	 *
	 * @since 1.0.0
	 *
	 * @return	boolean
	 */
	public function mp_pointers_check() {
		$mp_pointers = $this->mp_pointers();
		foreach ( $mp_pointers as $pointer => $array ) {
			if ( $array['active'] )
				return true;
		}
	}

	/**
	 * Add tooltip pointers to show off certain elements in the admin
	 *
	 * This function is attached to the 'admin_enqueue_scripts' action hook.
	 *
	 * @since 1.0.0
	 */
	public function mp_pointers_header() {
		if ( $this->mp_pointers_check() ) {
			add_action( 'admin_print_footer_scripts', array( $this, 'mp_pointers_footer' ) );

			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_style( 'wp-pointer' );
		}
	}

	/**
	 * Add tooltip pointer script to admin footer
	 *
	 * This function is attached to the 'admin_print_footer_scripts' action hook.
	 *
	 * @since 1.0.0
	 */
	public function mp_pointers_footer() {
		$mp_pointers = $this->mp_pointers();
		?>
<script>
( function($) {
<?php
foreach ( $mp_pointers as $pointer => $array ) {
	if ( $array['active'] ) {
		?>
$( '<?php echo $array['anchor_id']; ?>' ).pointer( {
    content: '<?php echo $array['content']; ?>',
    position: {
        edge: '<?php echo $array['edge']; ?>',
        align: '<?php echo $array['align']; ?>'
    },
    close: function() {
        $.post( ajaxurl, {
            pointer: '<?php echo $pointer; ?>',
            action: 'dismiss-wp-pointer'
        } );
    }
} ).pointer( 'open' );
    	<?php
    }
}
?>
} )(jQuery);
</script>
		<?php
	}
}
$bavotasan_tooltips = new Bavotasan_Tooltips;