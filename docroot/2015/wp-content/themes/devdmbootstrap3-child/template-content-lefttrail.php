<?php
/*
 * Template Name: Content-Left-Rail
 */
?>
<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<!-- big background image -->

<div class="jumbo-container jumbo" >
<div class="container">
        <div class="jumbo-copy">
            EPIC is the premier international gathering on the current and future practice of ethnography in the business world.
        </div><!--jumbo-copy-->
    </div>
</div><!--jumbo-container-->

<!-- start content container -->
<div class="container">
    <div class="row dmbs-content">

                <?php //get the left sidebar ?>
                <?php get_sidebar( 'left' ); ?>

            <div class="col-md-8 dmbs-main">

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

            

            </div>
               
        </div>
    </div>
</div>

<!-- end content container -->

<?php get_footer(); ?>
