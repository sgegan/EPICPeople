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

?>