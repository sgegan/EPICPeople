<?php
/*
 * Template Name: Home - Basic
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
                <div class="jumbo-copy">Building Bridges</div>
                <div class="jumbo-sub-copy">Brazil</div>
                </div>
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
                <div class="col-md-8 pad-top">

                    <?php // theloop
                    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        <!--<h1 class="page-header"><?php the_title() ;?></h1>-->
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                        <?php comments_template(); ?>

                    <?php endwhile; ?>
                    <?php else: ?>

                        <?php get_404_template(); ?>

                    <?php endif; ?>

                    <!--<div class="venue_container white-text">
                        <h2 class="white-text">VENUE</h2>
                        The Center for Positive Marketing at Fordham University Lincoln Center is dedicated to upholding marketing as a force for satisfying the interdependent needs of organizational stakeholders, individual citizens, and society at large. The Center recognizes the value exchange relationship between consumers and marketers, and encourages leveraging this relationship for mutual benefit. 
                       <a href="#" class="white-text-link">Learn more!</a>
                    </div>-->
                </div><!--col-->
            </div><!-- content above-->
    </div><!--row-->
</div><!--container-->
</div>

<!-- end content container -->

<?php get_footer(); ?>




