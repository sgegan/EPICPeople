<?php
/*
 * Template Name: Sponsors
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
         
        <!-- Row 1 Headshots Start -->

        <div class="row committee-placement">
            <div class="col-md-6 box-header">           
                <h3><?php the_field('box_header_1'); ?></h3>
            </div><!--col-->
        </div><!--row-->
        <div class="row committee-placement">
            <div class="col-sm-3"><img src="<?php the_field('headshot_1'); ?>" class="headshot-size"/>        
                <div class="headshot-info"><?php the_field('headshot_info_1'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_2'); ?>" class="headshot-size hidden"/>             
                <div class="headshot-info"><?php the_field('headshot_info_2'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_3'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_3'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_4'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_4'); ?></div>
            </div><!--col-->

        <div class="row">
            <!--<div class="col-md-12 horiz-line">           
            </div>--><!--col-->
            <?php the_field('horizontal_rule_1'); ?>
        </div><!--row-->
        </div>

        <!-- Row 1 Headshots END -->

  <!-- Row 2 Headshots Start -->

        <div class="row committee-placement">
            <div class="col-md-6 box-header">           
                <h3><?php the_field('box_header_2'); ?></h3>
            </div><!--col-->
        </div><!--row-->
        <div class="row committee-placement">
            <div class="col-sm-3"><img src="<?php the_field('headshot_5'); ?>" class="headshot-size"/>        
                <div class="headshot-info"><?php the_field('headshot_info_5'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_6'); ?>" class="headshot-size hidden"/>             
                <div class="headshot-info"><?php the_field('headshot_info_6'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_7'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_7'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_8'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_8'); ?></div>
            </div><!--col-->

        <div class="row">
            <!--<div class="col-md-12 horiz-line">           
            </div>--><!--col-->
            <?php the_field('horizontal_rule_1'); ?>
        </div><!--row-->
        </div>

        <!-- Row 2 Headshots END -->

        <!-- Row 3 Headshots Start -->

        <div class="row committee-placement">
            <div class="col-md-6 box-header">           
                <h3><?php the_field('box_header_3'); ?></h3>
            </div><!--col-->
        </div><!--row-->
        <div class="row committee-placement">
            <div class="col-sm-3"><img src="<?php the_field('headshot_9'); ?>" class="headshot-size"/>        
                <div class="headshot-info"><?php the_field('headshot_info_9'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_10'); ?>" class="headshot-size"/>             
                <div class="headshot-info"><?php the_field('headshot_info_10'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_11'); ?>" class="headshot-size"/>          
                <div class="headshot-info"><?php the_field('headshot_info_11'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_12'); ?>" class="headshot-size"/>          
                <div class="headshot-info"><?php the_field('headshot_info_12'); ?></div>
            </div><!--col-->

            <div class="row">
                <!--<div class="col-md-12 horiz-line">           
                </div>--><!--col-->
                <?php the_field('horizontal_rule_3'); ?>
            </div><!--row-->

        </div>
        <!--2nd row silver-->
        <div class="row committee-placement">
            <div class="col-sm-3"><img src="<?php the_field('headshot_17'); ?>" class="headshot-size"/>        
                <div class="headshot-info"><?php the_field('headshot_info_17'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_18'); ?>" class="headshot-size"/>             
                <div class="headshot-info"><?php the_field('headshot_info_18'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_19'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_19'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_20'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_20'); ?></div>
            </div><!--col-->

            <div class="row">
                <!--<div class="col-md-12 horiz-line">           
                </div>--><!--col-->
                <?php the_field('horizontal_rule_5'); ?>
            </div><!--row-->

        </div>
        <!--2nd row silver END-->

        <!-- Row 3 Headshots END -->

        <!-- Row 4 Headshots Start -->

        <div class="row committee-placement">
            <div class="col-md-6 box-header">           
                <h3><?php the_field('box_header_4'); ?></h3>
            </div><!--col-->
        </div><!--row-->
        <div class="row committee-placement">
            <div class="col-sm-3"><img src="<?php the_field('headshot_13'); ?>" class="headshot-size"/>        
                <div class="headshot-info"><?php the_field('headshot_info_13'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_14'); ?>" class="headshot-size"/>             
                <div class="headshot-info"><?php the_field('headshot_info_14'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_15'); ?>" class="headshot-size"/>          
                <div class="headshot-info"><?php the_field('headshot_info_15'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_16'); ?>" class="headshot-size"/>          
                <div class="headshot-info"><?php the_field('headshot_info_16'); ?></div>
            </div><!--col-->

            <div class="row">
                <!--<div class="col-md-12 horiz-line">           
                </div>--><!--col-->
                <?php the_field('horizontal_rule_4'); ?>
            </div><!--row-->

        </div>

        <!--2nd row Bronze-->

       <div class="row committee-placement">
            <div class="col-sm-3"><img src="<?php the_field('headshot_21'); ?>" class="headshot-size"/>        
                <div class="headshot-info"><?php the_field('headshot_info_21'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_22'); ?>" class="headshot-size hidden"/>             
                <div class="headshot-info"><?php the_field('headshot_info_22'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_23'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_23'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_24'); ?>" class="headshot-size hidden"/>          
                <div class="headshot-info"><?php the_field('headshot_info_24'); ?></div>
            </div><!--col-->

            <div class="row">
                <!--<div class="col-md-12 horiz-line">           
                </div>--><!--col-->
                <?php the_field('horizontal_rule_6'); ?>
            </div><!--row-->

        </div>


        <!--2nd row Bronze END-->

        <!--Distinguished Sponsors START-->

       <div class="row committee-placement">
            <div class="col-md-6 box-header">           
                <h3><?php the_field('box_header_5'); ?></h3>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_27'); ?>" class="headshot-size"/>        
                <div class="headshot-info"><?php the_field('headshot_info_27'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_26'); ?>" class="headshot-size"/>             
                <div class="headshot-info"><?php the_field('headshot_info_26'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_25'); ?>" class="headshot-size"/>          
                <div class="headshot-info"><?php the_field('headshot_info_25'); ?></div>
            </div><!--col-->
            <div class="col-sm-3"><img src="<?php the_field('headshot_28'); ?>" class="headshot-size"/>          
                <div class="headshot-info"><?php the_field('headshot_info_28'); ?></div>
            </div><!--col-->

            <div class="row">
                <!--<div class="col-md-12 horiz-line">           
                </div>--><!--col-->
                <?php the_field('horizontal_rule_7'); ?>
            </div><!--row-->

        </div>

        <!--Distinguished Sponsors END-->
          

    </div><!--container-->
</div><!--white-background-two-->

<?php get_footer(); ?>




