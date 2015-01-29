<?php
/*
 * Template Name: Program Schedule Index
 */
?>
<?php get_header(); ?>

<?php get_template_part('template-part', 'head'); ?>

<?php get_template_part('template-part', 'topnav'); ?>

<!-- start content container -->

<div class="white-background-two">
      <div class="container">


            <div class="row placement-schedule">


   

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
       		  
                  
                  <div class="row">
                                                  
                        
                        <div class="col-xs-12 col-sm-12 col-md-3 sg-back">  
                              <div class="sg-back-head-1 accent-back-schedule">
                                    <div class="schedule-headers">MONDAY 5</div>
                                    <?php the_field('prog_col_1'); ?>
                              </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 sg-back-white"> 
                           	                  <div class="sg-back-head-2 accent-back-schedule">
                                                      <div class="schedule-headers">TUESDAY 6</div>  
                                                      <?php the_field('prog_col_2'); ?>
                                                </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 sg-back-2"> 
                            	                  <div class="sg-back-head-1 accent-back-schedule">
                                                      <div class="schedule-headers">WEDNESDAY 7</div>                          
                                                      <?php the_field('prog_col_3'); ?>
                                                </div> 
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 sg-back-white-2">
                                                <div class="sg-back-head-2 accent-back-schedule">
                                                      <div class="schedule-headers">THURSDAY 8</div>
                                                      <?php the_field('prog_col_4'); ?> 
                                                </div>
                        </div>
                  </div><!--row-->

            </div><!--row dmbs-content-->
      </div><!--container-->

</div><!--white-background-two-->
<!-- end content container -->

<?php get_footer(); ?>

<!--<a href="" class="schedule-headers">MONDAY 8</a>-->
