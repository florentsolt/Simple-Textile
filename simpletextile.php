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
include_once(dirname(__FILE__) . "/filter.php");
include_once(dirname(__FILE__) . "/admin.php");

/**
"Renders" a PHP file as usual, and returns the parsed contents as a string.
Variables can be passed to the template, and are prefixed with st_
**/
function simpletextile_render($template, $variables = array()) {
	ob_start();
	extract($variables, EXTR_PREFIX_ALL, "st");
	include(dirname(__FILE__) . "/" . $template . ".tpl");
	$contents = ob_get_contents();
	ob_end_clean();
	return $contents;
}

?>