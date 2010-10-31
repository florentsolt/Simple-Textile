<?php
/*
Plugin Name: Simple Textile
Plugin URI: http://github.com/rojekti/Simple-Textile/
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
		remove_filter("the_content", "wpautop");
		remove_filter("the_content", "wptexturize");
		remove_filter("the_excerpt", "wpautop");
		remove_filter("the_excerpt", "wptexturize");
		$textile = new Textile();
		return $textile->TextileThis($content);
	}
		
	
	return $content;

}

function simpletextile_meta() {
	add_meta_box("simpletextile_textilize", "Textile processing", "simpletextile_render_meta", "post", "normal", "high", get_the_ID());
	add_meta_box("simpletextile_textilize", "Textile processing", "simpletextile_render_meta", "page", "normal", "high", get_the_ID());
}

function simpletextile_render_meta($post, $metabox) {
	echo simpletextile_render("meta", array("id" => $post->ID));
}

function simpletextile_save_meta($id) {
	
	if (!wp_verify_nonce($_POST["simpletextile_nonce"], "textile_toggle")) {
		return $id;
	}
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $id;

	if ($_POST["post_type"] == "page") {
		if (!current_user_can("edit_page", $id))
			return $id;
	} else {
		if (!current_user_can("edit_post", $id))
			return $id;
	}
	
	// At last, we can check if to enable Textile!
	$toggle = $_POST["simpletextile_toggle"];
	if (!empty($toggle))
		update_post_meta($id, "textile", "true");
	else
		delete_post_meta($id, "textile");
	
	return $id;
	
}

function simpletextile_render($template, $variables = array()) {
	ob_start();
	extract($variables, EXTR_PREFIX_ALL, "st");
	include(dirname(__FILE__) . "/" . $template . ".tpl");
	$contents = ob_get_contents();
	ob_end_clean();
	return $contents;
}

add_filter("the_content", "simpletextile_filter", 0);
add_action("add_meta_boxes", "simpletextile_meta");
add_action("save_post", "simpletextile_save_meta");