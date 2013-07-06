<?php

	$dir = getcwd();//current directory
	
	$plugins_dir = str_replace('php', '', $dir);

	//Ok, so we will assume this is a regular WP installation.
	//This means that the plugin is contained after the wp-content
	//folder
	//
	//Let's use that as a delimiter to get the rest of the path.
	$arr = explode('wp-content', $plugins_dir);

	$plugin_js_path = 'wp-content' . $arr[1];
	

	define('CKEDITOR_BASEPATH', '../' . $plugin_js_path . 'ckeditor/');
	

	header('Content-Type: application/javascript');


?>
var CKEDITOR_BASEPATH = '<?php echo CKEDITOR_BASEPATH ?>';