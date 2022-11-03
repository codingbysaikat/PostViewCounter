<?php 
/*
Plugin Name: Posts View Counter
Plugin URI: 
Description: Count your post view and Display it 
Version: 1.0
Author: saikat mondal
Author URI: https://saikatmondal.con
License: GPLv2 or later
Text Domain: postview
Domain Path: /languages/
*/

/*
function wordcount_activation_hook(){}
register_activation_hook(__FILE__,"wordcount_activation_hook");

function wordcount_deactivation_hook(){}
register_deactivation_hook(__FILE__,"wordcount_deactivation_hook");
*/

$postview_postID = get_the_ID();


// Set Post View
function setPostViews(){
    global $postview_postID;
    $cookie_name = 'viewCount' . $postview_postID;
    $cookie_value = $postview_postID;
    setcookie($cookie_name, $cookie_value, time() + 60);
    $count_key = 'post_views_count';
    $count = get_post_meta($postview_postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postview_postID, $count_key);
        add_post_meta($postview_postID, $count_key, '0');
    } else {
        if (!isset($_COOKIE[$cookie_name])) {
            $count++;
            update_post_meta($postview_postID, $count_key, $count);
        }
    }
}
setPostViews();

// Get Post View
function getPostViews(){
    global $postview_postID;
    $count_key = 'post_views_count';
    $count = get_post_meta($postview_postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postview_postID, $count_key);
        add_post_meta($postview_postID, $count_key, '0');
        return "0 View";
    }
    return $count . ' Views';
}
$postview_count = getPostViews();

// Display the post view by the short code
function postview_display($attr,$content){
    global $postview_postID;

 return $postview_postID;
}
add_shortcode('postview','postview_display');