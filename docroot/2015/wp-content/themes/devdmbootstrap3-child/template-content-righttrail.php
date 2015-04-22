<?php
/*
 * Template Name: Content-Right-Rail
 */
?>
<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>



<!-- start content container -->
<div class="white-background-two">
    <div class="container">
        <div class="row">  

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

                 <div class="hidden-sm hidden-xs">
                     <?php //get the right sidebar ?>
                     <?php get_sidebar( 'right' ); ?>
                 </div>  
            </div>
        </div>
    </div>
</div><!--white-background-two-->

<!-- end content container -->

<?php get_footer(); ?>
