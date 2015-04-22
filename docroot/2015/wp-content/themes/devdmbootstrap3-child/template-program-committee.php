<?php
/*
 * Template Name: Program Committee
 */
?>
<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<!-- start content container -->
<div class="white-background-two">
    <div class="container">
        <div class="row committee-placement">
            <div class="col-sm-12">
                
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
        </div><!--row-->      
    </div><!--container-->
</div><!--white-background-two-->

<?php get_footer(); ?>




