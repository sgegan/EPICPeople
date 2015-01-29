<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @since 1.0.0
 */
?>
	<article id="post-0" class="post error404 not-found">
   	   	<h1 class="entry-title"><?php _e( 'Nothing found', 'magazine-premium' ); ?></h1>

        <div class="entry-content">
			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'magazine-premium' ), admin_url( 'post-new.php' ) ); ?></p>

			<?php else : ?>

            <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Maybe searching will help.', 'magazine-premium' ); ?></p>

            <?php endif; ?>
        </div>
    </article><!-- #post-0.post -->