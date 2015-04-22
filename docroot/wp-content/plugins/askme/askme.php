<?php
/**
 * Plugin Name: Ask Me
 * Plugin URI: http://de.kilo-moana.com/
 * Description: Simple Plugin to let your users ask questions.
 * Version: 0.4.3
 * Author: Timo Schiller, Alexander Siemer-Schmetzke
 * Author URI: http://de.kilo-moana.com/
 * Text Domain: askme-plugin
 * License: CC0
 */

function askme_init() {
    $plugin_dir = basename(dirname(__FILE__));
    load_plugin_textdomain( 'askme-plugin', false, $plugin_dir . '\\lang\\' );
}
add_action('plugins_loaded', 'askme_init');

function create_askme_postype() {

    $labels = array(
        'name' => __('Ask Me', 'askme-plugin'),
        'singular_name' => __('Ask Me', 'askme-plugin'),
        'add_new' => __('New Ask Me', 'askme-plugin'),
        'add_new_item' => __('Add new Ask Me', 'askme-plugin'),
        'edit_item' => __('Edit Ask Me', 'askme-plugin'),
        'new_item' => __('New Ask Me', 'askme-plugin'),
        'view_item' => __('View Ask Me', 'askme-plugin'),
        'search_items' => __('Search Ask Me s', 'askme-plugin'),
        'not_found' =>  __('No Ask Me found', 'askme-plugin'),
        'not_found_in_trash' => __('No Ask Me found in Trash', 'askme-plugin'),
        'parent_item_colon' => '',
    );

    $args = array(
        'label' => __('Ask me', 'askme-plugin'),
        'labels' => $labels,
        'public' => false,
        'can_export' => true,
        'show_ui' => true,
        'menu_position'     => 32,
        '_builtin' => false,
        'capability_type' => 'post',
        'menu_icon'         => plugin_dir_url(__FILE__).'images/icon.png',
        'hierarchical' => false,
        'rewrite' => array( "slug" => "askme" ),
        'supports'=> array('title', 'editor', 'comments'),
        'show_in_nav_menus' => true
    );

    register_post_type( 'askme', $args);
}

add_action( 'init', 'create_askme_postype' );

function askme_title_placeholder( $title ){

    $screen = get_current_screen();

    if ( 'askme' == $screen->post_type ){
        $title = __('your question here', 'askme-plugin');
    }

    return $title;
}

add_filter( 'enter_title_here', 'askme_title_placeholder' );

function show_asks(  ) {

    $isCaptcha = get_option('askme_setting_captcha');

    if($isCaptcha)
    {
        require_once(dirname(__FILE__).'/captcha/captcha.php');

        $publickey = get_option( 'askme_setting_captcha_publickey' );
        $privatekey = get_option( 'askme_setting_captcha_privatekey' );
        $resp = null;
        $error = null;
    }

    ob_start();

    wp_enqueue_style( 'askme', plugins_url('askme.css',__FILE__) );

    if( 'POST' == $_SERVER['REQUEST_METHOD']
        && !empty( $_POST['action'] )
        && $_POST['post_type'] == 'askme' && $_POST['question'] != "")
    {
        if ($isCaptcha && $_POST["recaptcha_response_field"])
        {
            $resp = recaptcha_check_answer ($privatekey,
                $_SERVER["REMOTE_ADDR"],
                $_POST["recaptcha_challenge_field"],
                $_POST["recaptcha_response_field"]);

            if ($resp->is_valid) {

                $title =  $_POST['question'];

                $post = array(
                    'post_title'	=> $title,
                    'post_status'	=> 'draft',
                    'post_type'		=> 'askme'
                );

                $id = wp_insert_post($post);

                echo "<div class='alert success'>".__('Your question has been submitted and will be published upon approval.')."</div>";

                if(isset($_POST['username']))
                {
                    add_post_meta($id, 'askme_username', $_POST['username']);
                }
                if(isset($_POST['email']))
                {
                    add_post_meta($id, 'askme_email', $_POST['email']);
                }

                if(get_option('askme_setting_email') == true)
                {
                    $mailtext = __('New Ask Me Received', 'askme-plugin');

                    $admin_email = get_option('admin_email');
                    wp_mail( $admin_email,  $mailtext, "Ask Me: ".$title);
                }

            }
            else
            {
                $error = $resp->error;
                echo "<div class='alert danger'>".__('<b>Error!</b> The Captcha was wrong.')."</div>";
            }
        }
        else if(!$isCaptcha)
        {
            $title =  $_POST['question'];

            $post = array(
                'post_title'	=> $title,
                'post_status'	=> 'draft',
                'post_type'		=> 'askme'
            );

            $id = wp_insert_post($post);

            echo "<div class='alert success'>".__('<b>Success!</b> Ask Me is now ready for approval.')."</div>";

            if(isset($_POST['username']))
            {
                add_post_meta($id, 'askme_username', $_POST['username']);
            }
            if(isset($_POST['email']))
            {
                add_post_meta($id, 'askme_email', $_POST['email']);
            }

            if(get_option('askme_setting_email') == true)
            {
                $mailtext = __('New Ask Me Received', 'askme-plugin');

                $admin_email = get_option('admin_email');
                wp_mail( $admin_email,  $mailtext, "Ask Me: ".$title);
            }
        }
        else
        {
            echo "<div class='alert danger'>".__('<b>Error!</b> You have to fill out the Captcha.')."</div>";
        }
    }
    else if('POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['question'] == "")
    {
        echo "<div class='alert danger'>".__('<b>Error!</b> You have to fill out the Question.')."</div>";
    }
    ?>

    <div id="askme">
        <form id="newask" name="newask" method="post" action="">

            <label for="question" id="questionLabel"><?php _e('Submit a question to an expert.', 'askme-plugin'); ?></label><br />
            <input type="text" id="question" value="" tabindex="1" size="20" name="question" />

            <?php
            if(get_option('askme_setting_user_response') == true)
            {
                echo display_userdatafields();
            }
            ?>

            <p><input type="submit" value="Submit" tabindex="6" id="submit" name="submit" /></p>

            <input type="hidden" name="post_type" id="post_type" value="askme" />
            <input type="hidden" name="action" value="post" />
            <?php wp_nonce_field( 'new-post' ); ?>
            <?php
            if($isCaptcha)
            {
                ?>
            <div id="captcha-div">
            <?php echo recaptcha_get_html($publickey, $error); ?>
            </div>
            <script>
                jQuery( "#question" ).focus(function() {
                    if ( jQuery( "#captcha-div" ).is( ":hidden" ) ) {
                        jQuery( "#captcha-div" ).slideDown( "slow" );
                    }
                });
            </script>
            <?php } ?>
        </form>

    <?php
    askme_output_normal();
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('askme', 'show_asks');

function display_userdatafields()
{
    ob_start(); ?>

    <div id="userdatafields">
        <div id="usernameDiv">
            <div id="usernamelabel"><b><label for="username"><?php _e('Name', 'askme-plugin'); ?></label></b></div>
            <div id="usernameinput"><input type="text" id="username" value="" tabindex="1" size="20" name="username" /></div>
        </div>
        <div id="useremailDiv">
            <div id="useremaillabel"><b><label for="email"><?php _e('Email', 'askme-plugin'); ?></label></b></div>
            <div id="useremailinput"><input type="email" id="email" value="" tabindex="1" size="20" name="email" /></div>
            <div id="emailmsg"><?php _e('If you provide an Email you will receive a message, once your Question is Answered.', 'askme-plugin'); ?></div>
        </div>
    </div>
    <div id="extenduserdata"><button type="button"><?php _e("Advanced Options", "askme-plugin"); ?></button></div>
    <script>
		jQuery( "#extenduserdata" ).click(function() {
			if ( jQuery( "#userdatafields" ).is( ":hidden" ) ) {
				jQuery( "#userdatafields" ).slideDown( "slow" );
			} else {
				jQuery( "#userdatafields" ).slideUp();
			}
		});
	</script>

    <?php $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function askme_output_normal()
{
		global $wp_query;
		
        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        } else if ( get_query_var('page') ) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        $args = array(
            'post_type' => 'askme',
            'post_status' => 'publish',
            'paged' => $paged,
            'orderby' => 'date',
            'posts_per_page' => 5
        );

        query_posts($args);

        while ( have_posts() ) : the_post(); ?>

            <div class="entry">
                <div class="question">
                    <strong><?php the_title(); ?></strong>
                    <?php
						$customs = get_post_custom(get_the_ID());
						$username = ($customs['askme_username'][0]);
						if ($username) {
							echo ' from ' . $username;	
						}
					?>
                    <span class="date"><?php the_time('F j, Y'); ?></span>
                </div>

                <div class="answer">
                    <p><?php the_content(); ?></p>
                </div>
            </div>

            <hr />

        <?php endwhile; ?>
        <?php askme_pagination($wp_query->max_num_pages); ?>
    </div> <!-- Ende Askme Div -->
    <?php
    wp_reset_query();
}

function add_askme_columns($askme_columns) {
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['date'] = __('Date', 'askme-plugin');
    $new_columns['title'] = __('Ask Me', 'askme-plugin');
    $new_columns['answer'] = __('Answer', 'askme-plugin');
    $new_columns['username'] = __('Username', 'askme-plugin');
    $new_columns['email'] = __('Email', 'askme-plugin');

    return $new_columns;
}

add_filter('manage_edit-askme_columns', 'add_askme_columns');

add_action('manage_askme_posts_custom_column', 'manage_askme_columns', 10, 2);

function manage_askme_columns($column_name, $id) {
    $customs = get_post_custom($id);

    switch ($column_name) {
        case 'id':
            echo $id;
            break;
        case 'username':
            if(isset($customs['askme_username']))
            {
                foreach( $customs['askme_username'] as $key => $value)
                    echo $value;
            }
            break;
        case 'email':
            if(isset($customs['askme_email']))
            {
                foreach( $customs['askme_email'] as $key => $value)
                    echo $value;
            }
            break;
        case 'answer':
            echo get_the_content($id);
            break;
        default:
            break;
    }
}



function askme_pagination($pages = '', $range = 5)
{
    $showitems = ($range * 2)+1;

    global $paged;

    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    } else if ( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;

        if(!$pages)
        {
            $pages = 1;
        }
    }

    if(1 != $pages)
    {
        ?>
        <div class="askme_pagination"><span><?php echo __('Page', 'askme-plugin'); ?> <?php echo $paged; ?> <?php echo __('of', 'askme-plugin');?> <?php echo $pages; ?></span>
            <?php
            if($paged > 2 && $paged > $range+1 && $showitems < $pages)
            { ?>

                <a href="<?php echo get_pagenum_link(1); ?>">&laquo;</a>

            <?php }

            if($paged > 1)
            { ?>
                <a href="<?php echo get_pagenum_link($paged - 1); ?>">&lsaquo;</a>;
            <?php }

            for ($i=1; $i <= $pages; $i++)
            {
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                {
                    if ($paged == $i)
                    { ?>
                        <span class="current"><?php echo $i; ?></span>
                    <?php }
                    else
                    { ?>
                        <a href="<?php echo get_pagenum_link($i); ?>" class="inactive"><?php echo $i; ?></a>
                    <?php }
                }
            }

            if ($paged < $pages)
            { ?>
                <a href="<?php echo get_pagenum_link($paged + 1); ?>">&rsaquo;</a>
            <?php }
            if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages)
            { ?>
                <a href="<?php echo get_pagenum_link($pages); ?>">&raquo;</a>
            <?php }
            ?>
        </div>
        <?php
    }
}

function askme_stats() {
?>
    <h4>Ask Me - Overview</h4>
    <br />
    <ul>
	    <li class="post-count">
            <?php
            $type = 'askme';
            $args = array(
                'post_type' => $type,
                'post_status' => 'publish',
                'posts_per_page' => -1);

            $my_query = query_posts( $args );
            ?>

            <a href="edit.php?post_type=askme&post_status=publish"><?php echo count($my_query); ?> <?php _e('published', 'askme-plugin'); ?></a>
        </li>
        <li class="page-count">
            <?php
            $args = array(
                'post_type' => $type,
                'post_status' => 'draft',
                'posts_per_page' => -1);

            $my_query = query_posts( $args );
            ?>
            <a href="edit.php?post_type=askme&post_status=draft"><?php echo count($my_query); ?> <?php _e('open', 'askme-plugin'); ?></a>

        </li>
    </ul>
<?php
    wp_reset_query();
}

add_action('activity_box_end', 'askme_stats');

function askme_settings_init() {

    add_settings_section(
        'askme_setting_section',
        __('Ask Me Settings', 'askme-plugin'),
        'askme_setting_section_callback',
        'reading'
    );

 	add_settings_field(
        'askme_setting_email',
        __('E-Mail Alert on new Ask', 'askme-plugin'),
        'askme_setting_callback',
        'reading',
        'askme_setting_section'
    );

    register_setting( 'reading', 'askme_setting_email' );

    add_settings_field(
        'askme_setting_captcha',
        __('Show Captcha', 'askme-plugin'),
        'askme_captcha_callback',
        'reading',
        'askme_setting_section'
    );

    register_setting( 'reading', 'askme_setting_captcha' );

    add_settings_field(
        'askme_setting_captcha_publickey',
        __('Captcha Public Key', 'askme-plugin'),
        'askme_captcha_puk_callback',
        'reading',
        'askme_setting_section'
    );

    register_setting( 'reading', 'askme_setting_captcha_publickey' );

    add_settings_field(
        'askme_setting_captcha_privatekey',
        __('Captcha Private Key', 'askme-plugin'),
        'askme_captcha_prk_callback',
        'reading',
        'askme_setting_section'
    );

    register_setting( 'reading', 'askme_setting_captcha_privatekey' );

    add_settings_field(
        'askme_setting_user_response',
        __('User Fields', 'askme-plugin'),
        'askme_setting_user_response_callback',
        'reading',
        'askme_setting_section'
    );

    register_setting( 'reading', 'askme_setting_user_response' );
 }

 add_action( 'admin_init', 'askme_settings_init' );

function askme_setting_section_callback() {
     echo '<p>'.__("Configure your Asks", "askme-plugin").'</p>';
}

function askme_setting_callback() {
    echo '<input name="askme_setting_email" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'askme_setting_email' ), false ) . ' />';
}

function askme_captcha_callback() {
    echo '<input name="askme_setting_captcha" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'askme_setting_captcha' ), false ) . ' />';
}

function askme_setting_user_response_callback() {
    echo '<input name="askme_setting_user_response" id="gv_thumbnails_insert_into_excerpt" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'askme_setting_user_response' ), false ) . ' />' . __('Would you like to display User Fields, like E-Mail and Username? This would give your users the possibility to receive a Notification if an Answer is answered.', 'askme-plugin');
}

function askme_captcha_prk_callback() {
    echo '<input name="askme_setting_captcha_privatekey" id="gv_thumbnails_insert_into_excerpt" type="text" class="code" value="' . get_option( 'askme_setting_captcha_privatekey' ) . '" />
        <p class="description">' . __('Get a key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank">https://www.google.com/recaptcha/admin/create</a>', 'askme-plugin') . "</p>";
}

function askme_captcha_puk_callback() {
    echo '<input name="askme_setting_captcha_publickey" id="gv_thumbnails_insert_into_excerpt" type="text" class="code" value="' . get_option( 'askme_setting_captcha_publickey' ) . '" />
        <p class="description">' . __('Get a key from <a href="https://www.google.com/recaptcha/admin/create" target="_blank">https://www.google.com/recaptcha/admin/create</a>', 'askme-plugin') . "</p>";
}

add_action( 'admin_menu', 'add_user_menu_bubble' );

function add_user_menu_bubble() {

    global $menu;

    foreach ( $menu as $key => $value ) {
        if ( $menu[$key][2] == 'edit.php?post_type=askme' ) {

            $type = 'askme';
            $args = array(
                'post_type' => $type,
                'post_status' => 'draft',
                'posts_per_page' => -1);

            $my_query = query_posts( $args );
            if(count($my_query) > 0)
            {
                $menu[$key][0] .= '    <span class="update-plugins"><span class="plugin-count">' . count($my_query) . '</span></span> ';
            }
            wp_reset_query();
            return;
        }
    }

}

function publish_askme_hook($id)
{
    $customs = get_post_custom($id);
    if(isset($customs['askme_email']))
        wp_mail( $customs['askme_email'],  get_bloginfo('name').__(' - Ask Me - Answer Received', 'askme-plugin'), __('Your Ask Me has been Answered!', 'askme-plugin'));
}

add_action( 'publish_askme', 'publish_askme_hook' );
?>