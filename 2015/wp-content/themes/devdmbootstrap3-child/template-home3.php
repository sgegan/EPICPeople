<?php
/*
 * Template Name: Home V3
 */
?>
<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<!-- big background image -->


<div class="hidden-xs hidden-sm" >
    <div class="jumbo-container">
        <div class="container white-background">
            <?php the_field('homepage_slider'); ?>
    </div>
    </div>
</div>

<div class="jumbo-container hidden-md hidden-lg" >
        <div class="jumbo">
            <div class="container">
                <div class="jumbo-copy"> EPIC is the premier international gathering on the current and future practice of ethnography in the business world. </div>
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
                    <div class="col-md-6">

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

            </div><!--col-->

            <div class="col-md-3 background-blue">
                <?php the_field('blue_box_home'); ?>
            </div>

            <div class="row">
                <div class="col-xs-8 horiz-line-home">

                </div>
            </div>

             <div class="row">
                <div class="col-sm-6">
                 <h3>KEYNOTE SPEAKERS</h3>
                </div>
                <div class="col-sm-6 learn-more-speakers">
                 <?php the_field('more-keynotes-cta'); ?>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-3 push-down-headshots">
                    <img src="<?php the_field('keynote_headshot_1'); ?>" class="headshot-size"/>             
                    <?php the_field('keynote_info_1'); ?>
                </div>
                <div class="col-sm-3 push-down-headshots">
                    <img src="<?php the_field('keynote_headshot_2'); ?>" class="headshot-size"/>             
                    <?php the_field('keynote_info_2'); ?>
                </div>
                <div class="col-sm-3 push-down-headshots">
                    <img src="<?php the_field('keynote_headshot_3'); ?>" class="headshot-size"/>             
                    <?php the_field('keynote_info_3'); ?>
                </div>
                <div class="col-sm-3 push-down-headshots">
                    <img src="<?php the_field('keynote_headshot_4'); ?>" class="headshot-size"/>             
                    <?php the_field('keynote_info_4'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-8 horiz-line-home">

                </div>
            </div>

            <div class="row">
            <div class="col-sm-6 about_container white-text">
            <?php the_field('about_promo'); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
            <?php the_field('cfp_promo'); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
             <h3>EPIC TWEETS</h3>

<a class="twitter-timeline" height="230" href="https://twitter.com/epiconference"  data-widget-id="450704693258235904" data-chrome="nofooter transparent noheader" border-color="#bebebe">Tweets by @epiconference</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

            </div>
            </div>

            </div><!-- content above-->
        </div><!--row dmbs-content-->
    </div><!--container-->
</div><!--white-background-two-->

<!-- end content container -->

<?php get_footer(); ?>




