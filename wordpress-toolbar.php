<?php
	
	/*
	 * Plugin Name: WordPress Toolbar
	 * Version: 2.2.7
	 * Plugin URI: http://abhinavsingh.com/blog/2009/02/wordpress-toolbar-plugin
	 * Description: WordPress Toolbar is a unique plugin which automatically enables a toolbar for all outgoing links from your blog post and pages. Customize your toolbar url from <a href="/wp-admin/options-general.php?page=wordpress-toolbar">admin panel</a>. It also support tinyurl generation and adding social sharing icons at end of the blog post and pages.
	 * Author: Abhinav Singh
	 * Author URI: http://abhinavsingh.com/blog
	 */

	include_once('wp-toolbar.php');
	$_wordpress_toolbar = new wordpressToolbar();

?>
