<?php
add_filter('wp_dropdown_users', 'MySwitchUser');
function MySwitchUser($output)
{

    //global $post is available here, hence you can check for the post type here
    $users = get_users();

    $output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";

    //Leave the admin in the list
    $output .= "<option value=\"1\">Admin</option>";
    foreach($users as $user)
    {
        $sel = ($post->post_author == $user->ID)?"selected='selected'":'';
        $output .= '<option value="'.$user->ID.'"'.$sel.'>'.$user->display_name.'</option>';
    }
    $output .= "</select>";

    return $output;
}

add_filter( 'bbp_show_lead_topic', '__return_true' );

// // HSTS ENABLED

// add_action( 'send_headers', 'tgm_io_strict_transport_security' );
// /**
//  * Enables the HTTP Strict Transport Security (HSTS) header.
//  *
//  * @since 1.0.0
//  */
// function tgm_io_strict_transport_security() {
 
//     header( 'Strict-Transport-Security: max-age=10886400; includeSubDomains; preload' );
 
// }

add_action('ws_plugin__s2member_during_paypal_return_before_no_return_data', 's2hack_force_return_no_txn_data');

function s2hack_force_return_no_txn_data($vars) {
    $url = $vars['custom_success_redirection'];
    
    if($url) {
        header('Location: '.$url);
        exit();
    }
}

?>