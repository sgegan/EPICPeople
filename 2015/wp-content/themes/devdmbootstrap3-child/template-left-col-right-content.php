<?php
/*
 * Template Name: left-col-content-right
 */
?>
<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>



<!-- start content container -->
<div class="white-background-two">
    <div class="container">
            <div class="row placement-schedule">
                <h1 class="page-header"><?php the_title() ;?></h1>
            </div>
            <div class="row col-sm-12 placement-schedule-nav" id="nav-daily-schedule">
                <?php wp_nav_menu( array( 'theme_location' => 'schedule-nav') ); ?>
            </div>


            <div class="row placement-schedule">

                <div class="col-xs-12 col-sm-12 col-md-3 sg-back-daily accent-back-schedule sg-padding-daily">
                                   
                        <?php the_field('prog_col_daily'); ?>

                </div><!--col-->

                <div class="col-xs-12 col-sm-12 col-md-9 sg-padding-daily">

                    <?php // theloop
                    if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                        <?php comments_template(); ?>

                    <?php endwhile; ?>
                    <?php else: ?>

                        <?php get_404_template(); ?>

                    <?php endif; ?>

                </div><!--col-->
                

            </div>
        </div>
    </div>
</div><!--white-background-two-->
<!-- end content container -->

<?php get_footer(); ?>
