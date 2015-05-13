<?php
/*
This allows us to use whatever domain we want for the siteurl
*/

add_filter ( 'pre_option_home', 'use_normal_siteurl' );
add_filter ( 'pre_option_siteurl', 'use_normal_siteurl' );
function use_normal_siteurl( ) {
     $https = ($_SERVER['HTTPS'])? 's' : '';
     return "http" .$https. "://" . $_SERVER['SERVER_NAME'] . '/2015';
}
