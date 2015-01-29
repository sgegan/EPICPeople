<?php
/*
 * Template Name: Home Test
 */
?>
<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<!-- big background image -->

<div class="row jumbo-container hidden-xs hidden-sm" >
    <div class="container">
        <div class="col-md-12 white-background">
                <?php the_field('homepage_slider'); ?>
        </div>
    </div>
</div><!--jumbo-container-->



<!-- start content container -->
<div class="white-background-two">
<div class="container">
    <div class="row dmbs-content">
            <div class="col-md-12 content-above">
                    <?php //get the left sidebar ?>
                    <?php get_sidebar( 'left' ); ?>
                <div class="col-md-8">

                    <?php // theloop
                    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        <h1 class="page-header"><?php the_title() ;?></h1>
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                        <?php comments_template(); ?>

                    <?php endwhile; ?>
                    <?php else: ?>

                        <?php get_404_template(); ?>

                    <?php endif; ?>

                    <div class="venue_container white-text">
                        <?php the_field('home_venue_promo'); ?>
                    </div>
                </div><!--col-->
            </div><!-- content above-->
    </div><!--row-->
</div><!--container-->
</div><!--white-background-two-->

<!-- end content container -->

<?php get_footer(); ?>




