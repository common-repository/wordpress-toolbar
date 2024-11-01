<?php
	
	if(!isset($_GET['wptbhash']) || !isset($_GET['wptbto'])) {
		echo "<html><head></head>";
		echo "<body><center>";
		echo "<h1><a href='http://wordpress.org/extend/plugins/wordpress-toolbar/'>Wordpress Toolbar Plugin</a></h1>";
		echo "<strong>Working!</strong> Though required parameters are missing.";
		echo "</center></body></html>";
		exit;
	}

	include_once('../../../wp-config.php');
	include_once('../../../wp-load.php');
	include_once('../../../wp-includes/wp-db.php');
	include_once('wordpress-toolbar.php');
	
	$wptb_hash = $_GET['wptbhash'];

	/*
	 * $wptb_param description:
	 * [0] blog url
	 * [1] blog title
	 * [2] home url
	 * [3] home title
	 * [4] to url
	 * [5] wordpress toolbar extra folder base url
	 * [6] wordpress toolbar social config
	 * [7] wordpress toolbar custom config
	 * [8] wordpress toolbar skin config
	*/
	$wptb_param = explode('<wptb>', base64_decode($wptb_hash));
	$wptb_param[4] = $_GET['wptbto'];
	$wptb_param[5] = $wptb_param[2]."/wp-content/plugins/wordpress-toolbar/extra";
	
	$options = $wpdb->get_results("SELECT * FROM {$wpdb->options} where option_name in ('wordpress_toolbar_social', 'wordpress_toolbar_skin', 'wordpress_toolbar_custom')");
	foreach($options as $result) {
		switch($result->option_name) {
			case 'wordpress_toolbar_social':
				$wordpress_toolbar_social = $result->option_value;
				$wptb_param[6] = explode(",", $wordpress_toolbar_social);
				break;
			case 'wordpress_toolbar_custom':
				$wptb_param[7] = $result->option_value;
				break;
			case 'wordpress_toolbar_skin':
				$wptb_param[8] = $result->option_value;
				break;
		}
	}
	
	if($wptb_param[2] == get_bloginfo('url') && $wptb_param[3] == get_bloginfo('name'))	
		echo $_wordpress_toolbar->getToolbarHTML($wptb_param);
	else
		header('Location: '.$wptb_param[4]);

?>
