<?php

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

add_action("add_meta_boxes", "simpletextile_meta");
add_action("save_post", "simpletextile_save_meta");