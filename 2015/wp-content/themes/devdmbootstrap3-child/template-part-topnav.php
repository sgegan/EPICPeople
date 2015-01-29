
<?php if ( has_nav_menu( 'main_menu' ) ) : ?>

    <div class="row dmbs-top-menu">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-1-collapse">
                        <col-md- class="sr-only">Toggle navigation</col-md->
                        <col-md- class="icon-bar"></col-md->
                        <col-md- class="icon-bar"></col-md->
                        <col-md- class="icon-bar"></col-md->
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-1-collapse">
                    <?php
                    wp_nav_menu( array(
                            'theme_location'    => 'main_menu',
                            'depth'             => 2,
                            'container'         => '',
                            'container_class'   => '',
                            'menu_class'        => 'nav navbar-nav',
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'walker'            => new wp_bootstrap_navwalker())
                    );
                    ?>
                    <!--<form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" name="s" id="search" value="<?php the_search_query(); ?>">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>-->
                </div>
            </div><!--container-->
        </nav>
    </div><!--row-->

<?php endif; ?>