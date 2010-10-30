<?php
/*
Plugin Name: Simple Textile
Plugin URI: http://github.com/rojekti/simpleTextile/
Description: Simple Textile processing for posts with no BS. Uses the PHP Textile library by Dean Allen.
Version: 0.1
Author: rojekti
Author URI: http://rojekti.fi/
License: GPL2
*/

include_once(dirname(__FILE__) . "/classTextile.php");

function simpletextile_filter($content) {

	$post = get_the_ID();
	$toggle = get_post_meta($post, "textile", true);
	
	if (!empty($toggle)) {
		$textile = new Textile();
		return $textile->TextileThis($content);
	}
	
	return $content;

}

remove_filter("the_content", "wpautop");
remove_filter("the_content", "wptexturize");
remove_filter("the_excerpt", "wpautop");
remove_filter("the_excerpt", "wptexturize");

add_filter("the_content", "simpletextile_filter", 0);

?>