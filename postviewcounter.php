<?php 
/*
Plugin Name: Posts View Counter
Plugin URI: https://github.com/codingbysaikat/WordCounter.git
Description: Count your post view and Display it 
Version: 1.0
Author: saikat mondal
Author URI: https://saikatmondal.con
License: GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Update URI:        https://example.com/my-plugin/
Text Domain: countview
Domain Path: /languages/
*/

/*
function wordcount_activation_hook(){}
register_activation_hook(__FILE__,"wordcount_activation_hook");

function wordcount_deactivation_hook(){}
register_deactivation_hook(__FILE__,"wordcount_deactivation_hook");
*/
function wordcount_load_textdomain() {
    load_plugin_textdomain( 'countview', false, dirname( __FILE__ ) . "/languages" );
}




    $countview_current_post = get_the_ID();


// Set Post View
function countview_setPostViews($postID){
    $cookie_name = 'viewCount' . $postID;
    $cookie_value = $postID;
    setcookie($cookie_name, $cookie_value, time() + 0);
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        if (!isset($_COOKIE[$cookie_name])) {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}
countview_setPostViews($countview_current_post );

// Get Post View
function countview_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count . ' Views';
}
$countview_count = countview_getPostViews($countview_current_post);


// Display the post view by the short code
function postview_display($attr,$content){
    global $countview_count;

 return $countview_count;
}
add_shortcode('postview','postview_display');