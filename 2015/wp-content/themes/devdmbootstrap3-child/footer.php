<footer>

	<div class="row dmbs-footer">
		<!--<div class="container">-->

		<div class="container">

			<div class="col-md-8 footer-copy">EPIC is a 501(c)(3) incorporated in the state of Oregon.
				<br/><br/>&copy; Epic 2015&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://epicpeople.org/about-epic/">About</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://epicpeople.org/contact/">Contact</a>

				<?php
				global $dm_settings;
				if ($dm_settings['author_credits'] != 0) : ?>
					<div class="row dmbs-author-credits">
						<p class="text-center"><a href="<?php global $developer_uri; echo esc_url($developer_uri); ?>">DevDmBootstrap3 <?php _e('created by','devdmbootstrap3') ?> Danny Machal</a></p>
						</div>
						<?php endif; ?>

						<?php get_template_part('template-part', 'footernav'); ?>
					</div>
					<div class="col-md-4 footer-copy">
						Stay Connected!
						<a href="https://twitter.com/epicpeople_org" class="social-icons-placement"><img src="http://epiconference.com/2014/wp-content/themes/devdmbootstrap3-child/img/twitter.png"></a>
						<a href="https://www.facebook.com/epiconference" class="social-icons-placement"><img src="http://epiconference.com/2014/wp-content/themes/devdmbootstrap3-child/img/facebook.png"></a>
						<!--<a href=""><img src="http://epiconference.com/2014/wp-content/themes/devdmbootstrap3-child/img/rss.png"></a>-->
						<!--</div>-->
					</div>

			</div><!-- col -->
		</div><!-- container -->

	</div><!-- row -->

</footer>
<!-- end main container -->

<?php wp_footer(); ?>
</body>
</html>

