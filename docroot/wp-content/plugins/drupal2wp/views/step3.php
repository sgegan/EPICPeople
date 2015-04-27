<h3 style="margin: 0;"><?php _e('Import in Progress', 'drupal2wp'); ?></h3>
<p class="description"><?php _e('This can take a long time depending on the size of the Drupal database.', 'drupal2wp'); ?></p>
<p><?php _e('Import status will be outputted below.', 'drupal2wp'); ?></p>
<iframe src="<?php echo wp_nonce_url( $_SERVER['REQUEST_URI'], 'drupal2wp_import_iframe', '_drupal2wp_wpnonce' ); ?>" width="100%" height="600px" frameBorder="0">Browser does not support iframes.</iframe>