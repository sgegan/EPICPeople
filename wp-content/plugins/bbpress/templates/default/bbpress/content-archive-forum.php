<?php

/**
 * Archive Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">


	<?php bbp_breadcrumb(); ?>

	<?php bbp_forum_subscription_link(); ?>

	<?php if ( bbp_allow_search() ) : ?>

		<div class="bbp-search-form">

			<?php bbp_get_template_part( 'form', 'search' ); ?>

		</div>

	<?php endif; ?>

	<h2 class="forum-subtitle">Welcome to EPIC Forums, where our community shares and creates ideas and resources about ethnographic praxis. Forums are open to all epicpeople.org subscribers and members. Please be respectful, stay on topic, attribute ideas, promote diverse voices, and do not post advertisements for products or services. For more info see <a href="http://epicpeople.org/terms-conditions/">Terms & Conditions</a>.</h2>

	<?php do_action( 'bbp_template_before_forums_index' ); ?>

	<?php if ( bbp_has_forums() ) : ?>

		<?php bbp_get_template_part( 'loop',     'forums'    ); ?>

	<?php else : ?>

		<?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_forums_index' ); ?>

</div>
