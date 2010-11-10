<?php

function simpletextile_filter($content) {

	$post = get_the_ID();
	$toggle = get_post_meta($post, "textile", true);
	
	if (!empty($toggle)) {
		$textile = new Textile();
		return $textile->TextileThis($content);
	} else {
		add_filter("the_content", "wpautop");
		add_filter("the_content", "wptexturize");
		add_filter("the_excerpt", "wpautop");
		add_filter("the_excerpt", "wptexturize");
	}
	
	return $content;

}

remove_filter("the_content", "wpautop");
remove_filter("the_content", "wptexturize");
remove_filter("the_excerpt", "wpautop");
remove_filter("the_excerpt", "wptexturize");
add_filter("the_content", "simpletextile_filter", 0);