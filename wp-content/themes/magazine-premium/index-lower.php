<?php
$advanced_front_page = get_option( 'mp_advanced_front_page' );
if ( ! empty( $advanced_front_page['upper'] ) && ! empty( $advanced_front_page['lower'] ) ) {
?>
<div id="lower-index" class="row">
	<div id="lower-index-main-content" <?php mp_lower_index_attr(); ?>>
		<?php
		if ( isset( $advanced_front_page['lower'] ) )
			advanced_front_page( $advanced_front_page['lower'], 'lower' );
		?>
	</div>
	<?php if ( is_active_sidebar( 'lower-sidebar' ) ) { ?>
	<div id="lower-sidebar" <?php mp_lower_index_sidebar_class(); ?> role="complementary">
		<?php dynamic_sidebar( 'lower-sidebar' ); ?>
	</div>
	<?php } ?>
</div>
<?php
}