<?php

	include_once('socialsites.php');
	class wordpressToolbar {

		var $wordpress_toolbar_skin = "su";
		var $wordpress_toolbar_custom = "bloghome,referpost,socialicons,commentback,getthisplugin,leavetoolbar,getplugin,";
		var $wordpress_toolbar_oinw = "y";
		var $wordpress_toolbar_sociable = "n";
		var $wordpress_toolbar_tinyurl = "n";
		var $wordpress_toolbar_excludedomains = "";
		var $wordpress_toolbar_social = "digg,delicious,facebook,googlebookmark,reddit,stumbleupon,dzone,linkedin,twitter,";

		function __construct() {
			$plugin_dir = basename(dirname(__FILE__));
			load_plugin_textdomain('wordpress-toolbar', 'wp-content/plugins/'.$plugin_dir, $plugin_dir);

			if(!isset($_GET['wptbto']) && !isset($_GET['wptbhash']))
				$this->init();
		}

		function __destruct() {
			
		}

		function init() {
			wp_enqueue_script('wordpressToolbar', '/wp-content/plugins/wordpress-toolbar/wp-toolbar.min.js', array('jquery'), '2.2.3');
			register_activation_hook(__FILE__, array(&$this, 'activate'));
			register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));	
			add_action('admin_menu', array(&$this, 'addAdmin'));
			add_filter('the_content', array(&$this, 'addToolbar'));
		}
		
		function activate() {	
			add_option('wordpress_toolbar_url', get_bloginfo('url').'/wp-content/plugins/wordpress-toolbar/toolbar.php');
			add_option('wordpress_toolbar_social', $this->wordpress_toolbar_social);
			add_option('wordpress_toolbar_excludedomains', $this->wordpress_toolbar_excludedomains);
			add_option('wordpress_toolbar_skin', $this->wordpress_toolbar_skin);
			if(!get_option('wordpress_toolbar_custom')) add_option('wordpress_toolbar_custom', $this->wordpress_toolbar_custom);
			else update_option('wordpress_toolbar_custom', $this->wordpress_toolbar_custom);
			add_option('wordpress_toolbar_oinw', $this->wordpress_toolbar_oinw);
			add_option('wordpress_toolbar_sociable', $this->wordpress_toolbar_sociable);
			add_option('wordpress_toolbar_tinyurl', $this->wordpress_toolbar_tinyurl);
		}

		function deactivate() {	
			//delete_option('wordpress_toolbar_url');
			//delete_option('wordpress_toolbar_social');
			//delete_option('wordpress_toolbar_excludedomains');
			//delete_option('wordpress_toolbar_skin');
			//delete_option('wordpress_toolbar_custom');
			//delete_option('wordpress_toolbar_oinw');
			//delete_option('wordpress_toolbar_sociable');
			//delete_option('wordpress_toolbar_tinyurl');
		}
		
		function addAdmin() {
			if(function_exists('add_options_page')) {
	      			add_options_page("Wordpress Toolbar Administration", "Wordpress Toolbar", 8, "wordpress-toolbar", array(&$this, 'populateAdmin'));
			} 
		}

		function populateAdmin() {
			global $wordpress_toolbar_social_sites;
		    
		  	$basedir = dirname(__FILE__);
			$domain = get_bloginfo('url');
			$toolbarURL = $domain.'/wp-content/plugin/wordpress-toolbar/toolbar.php';
	  
	  		if($_POST['wordpress_toolbar_administration']) {
	    			check_admin_referer("wordpress_toolbar_update_options");

				$wordpress_toolbar_url = $_POST['wordpress_toolbar_url'];	
				
    				$wordpress_toolbar_social = $_POST['wordpress_toolbar_social'];
    				$wordpress_toolbar_social_value = '';
    				while(list($key,$val) = @each($wordpress_toolbar_social)) {
	      				$wordpress_toolbar_social_value .= $val.",";
	      			}
	      
    				$wordpress_toolbar_excludedomains = $_POST['wordpress_toolbar_excludedomains'];
    				$wordpress_toolbar_skin = $_POST['wordpress_toolbar_skin'];
    
    				$wordpress_toolbar_custom = $_POST['wordpress_toolbar_custom'];
    				$wordpress_toolbar_custom_value = '';
    				while(list($key,$val) = @each($wordpress_toolbar_custom)) {
	      				$wordpress_toolbar_custom_value .= $val.",";
	      			}
	      
    				$wordpress_toolbar_oinw = $_POST['wordpress_toolbar_oinw'];
    				if(!$wordpress_toolbar_oinw) $wordpress_toolbar_oinw = "n";
    				$wordpress_toolbar_sociable = $_POST['wordpress_toolbar_sociable'];
    				if(!$wordpress_toolbar_sociable) $wordpress_toolbar_sociable = "n";
    				$wordpress_toolbar_tinyurl = $_POST['wordpress_toolbar_tinyurl'];
    				if(!$wordpress_toolbar_tinyurl) $wordpress_toolbar_tinyurl = "n";
    
			    	if(get_option("wordpress_toolbar_url") === FALSE) add_option("wordpress_toolbar_url", $wordpress_toolbar_url);
			    	else update_option("wordpress_toolbar_url", $wordpress_toolbar_url);
				
				if(get_option("wordpress_toolbar_social") === FALSE) add_option("wordpress_toolbar_social", $wordpress_toolbar_social_value);
			    	else update_option("wordpress_toolbar_social", $wordpress_toolbar_social_value);
			    
			    	if(get_option("wordpress_toolbar_excludedomains") === FALSE) add_option("wordpress_toolbar_excludedomains", $wordpress_toolbar_excludedomains);
			    	else update_option("wordpress_toolbar_excludedomains", $wordpress_toolbar_excludedomains);
			    
			    	if(get_option("wordpress_toolbar_skin") === FALSE) add_option("wordpress_toolbar_skin", $wordpress_toolbar_skin);
			    	else update_option("wordpress_toolbar_skin", $wordpress_toolbar_skin);
			    
			    	if(get_option("wordpress_toolbar_custom") === FALSE) add_option("wordpress_toolbar_custom", $wordpress_toolbar_custom_value);
			    	else update_option("wordpress_toolbar_custom", $wordpress_toolbar_custom_value);
			    
			    	if(get_option("wordpress_toolbar_oinw") === FALSE) add_option("wordpress_toolbar_oinw", $wordpress_toolbar_oinw);
			    	else update_option("wordpress_toolbar_oinw", $wordpress_toolbar_oinw);
			    
			    	if(get_option("wordpress_toolbar_sociable") === FALSE) add_option("wordpress_toolbar_sociable", $wordpress_toolbar_sociable);
			    	else update_option("wordpress_toolbar_sociable", $wordpress_toolbar_sociable);
			    
			    	if(get_option("wordpress_toolbar_tinyurl") === FALSE) add_option("wordpress_toolbar_tinyurl", $wordpress_toolbar_tinyurl);
			    	else update_option("wordpress_toolbar_tinyurl", $wordpress_toolbar_tinyurl);
			}

			$wordpress_toolbar_url = get_option("wordpress_toolbar_url");
			if(!$wordpress_toolbar_url) $wordpress_toolbar_url = $toolbarURL;

			$wordpress_toolbar_social = get_option("wordpress_toolbar_social");
			if(!$wordpress_toolbar_social) $wordpress_toolbar_social = $this->wordpress_toolbar_social;
			$wordpress_toolbar_social = explode(",",$wordpress_toolbar_social);
			  
			$wordpress_toolbar_excludedomains = get_option("wordpress_toolbar_excludedomains");
			if(!$wordpress_toolbar_excludedomains) $wordpress_toolbar_excludedomains = $domain;
			  
			$wordpress_toolbar_skin = get_option("wordpress_toolbar_skin");
			if(!$wordpress_toolbar_skin) $wordpress_toolbar_skin = $this->wordpress_toolbar_skin;
			  
			$wordpress_toolbar_custom = get_option("wordpress_toolbar_custom");
			if(!$wordpress_toolbar_custom) $wordpress_toolbar_custom = $this->wordpress_toolbar_custom;
			$wordpress_toolbar_custom = explode(",",$wordpress_toolbar_custom);
			 
			$wordpress_toolbar_oinw = get_option("wordpress_toolbar_oinw");
			if(!$wordpress_toolbar_oinw) $wordpress_toolbar_oinw = $this->wordpress_toolbar_oinw;

			$wordpress_toolbar_sociable = get_option("wordpress_toolbar_sociable");
			if(!$wordpress_toolbar_sociable) $wordpress_toolbar_sociable = $this->wordpress_toolbar_sociable;

			$wordpress_toolbar_tinyurl = get_option("wordpress_toolbar_tinyurl");
			if(!$wordpress_toolbar_tinyurl) $wordpress_toolbar_tinyurl = $this->wordpress_toolbar_tinyurl;
			  
			$skins = array();
			$skins_dir = $basedir."/extra/skins";
			if($skins_dir_handler = opendir($skins_dir)) {
				while(false !== ($file = readdir($skins_dir_handler))) {
					if($file != '.' && $file != '..') {
						array_push($skins,$file);
					}
				}
			    	closedir($skins_dir_handler);
			}
  
		  	$html = '';
		  	$html .= '<div id="wordpress-toolbar-administration">';
		  	$html .= '  <link rel="stylesheet" type="text/css" href="'.$domain.'/wp-content/plugins/wordpress-toolbar/extra/admin.css?v=9"/>';
		  	$html .= '  <h2>'.gettext('Wordpress Toolbar Administration Panel').'</h2>';
		  	$html .= '  <form method="post">';
		  	$html .= '    <ul class="top-menu">';
		  	$html .= '      <li class="top-menu-items active" id="toolbarsettings">';
		  	$html .= '        <p><a href="javascript:void(0)">'.gettext('Toolbar Settings').'</a></p>';
		  	$html .= '      </li>';
		  	$html .= '      <div style="clear:both"></div>';
		  	$html .= '    </ul>';
		  	$html .= '    <table cellspacing="0" cellpadding="0" border="0" id="toolbarsettingspanel">';
			$html .= '	<tr>';
			$html .= '	  <td class="left">';
			$html .= '	    <p>'.gettext('Toolbar URL:').'</p>';
			$html .= '	  </td>';
			$html .= '	  <td class="right">';
			$html .= '	    <input size="60px;" id="wordpress_toolbar_url" name="wordpress_toolbar_url" value="'.$wordpress_toolbar_url.'"/><br/>';
			$html .= '	    <small>';
			$html .= '	      '.gettext('DO READ ').'<a href="http://abhinavsingh.com/blog/2010/02/wordpress-toolbar-v-2-2-custom-toolbar-url-support-for-wpmu-and-bug-fixes/">'.gettext('Setup Steps').'</a>, '.gettext('before you customize your wordpress toolbar url').'<br/><br/>';
			$html .= '	    </small>';
			$html .= '	  </td>';
			$html .= '	</tr>';
			$html .= '      <tr>';
		  	$html .= '        <td class="left">';
		  	$html .= '          <p>'.gettext('Choose social icons:').'</p>';
		  	$html .= '        </td>';
		  	$html .= '        <td class="right">';
		  	$html .= '          <ul>';
  
		  	foreach($wordpress_toolbar_social_sites as $key => $value) {
				$socialsite = $key;
			      	$favicon = '';
			      	$parse_url = parse_url($value['url']);
				if(isset($parse_url['host'])) {
					$favicon = "http://www.google.com/s2/favicons?domain=".$parse_url['host'];
				}
		      		else if($key == 'email_link') {
		      			$favicon = $domain."/wp-content/plugins/wordpress-toolbar/extra/socialicons/email_link.png";
		    		}
			    	else if($key == 'printer') {
					$favicon = $domain."/wp-content/plugins/wordpress-toolbar/extra/socialicons/printer.png";
			    	}
		      		$html .= '<li class="socialset ';
		    		if(in_array($socialsite,$wordpress_toolbar_social)) { $html .= 'ssactive'; } else { $html .= 'ssinactive'; }
		    		$html .= '">';
		      		$html .= '<input name="wordpress_toolbar_social[]" type="checkbox" value="'.$socialsite.'" id="'.$socialsite.'" name="'.$socialsite.'" ';
		    		if(in_array($socialsite,$wordpress_toolbar_social)) { $html .= 'CHECKED />'; } else { $html .= '/>'; }
		    		$html .= '<label for="'.$socialsite.'"><img style="margin-right:5px;" src="'.$favicon.'"/>'.$socialsite.'</label>';
		      		$html .= '</li>';
		  	}
  
			$html .= '          </ul>';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '          <p>'.gettext('Exclude domains:').'</p>';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '          <textarea id="wordpress_toolbar_excludedomains" name="wordpress_toolbar_excludedomains">'.$wordpress_toolbar_excludedomains.'</textarea><br/>';
			$html .= '          <small>';
			$html .= '            (,) '.gettext('comma separated').'<br/><br/>';
			$html .= '            '.gettext('Wordpress Toolbar will be disabled for all links containing above domain names').'<br/> '.gettext('Example:').' <b>http://localhost/blog</b> '.gettext('WILL DISABLE toolbar for links like').' <b>http://localhost/blog/*</b><br/> '.gettext('but NOT DISABLE for').' <b>http://localhost/*</b>';
			$html .= '          </small>';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '          <p>'.gettext('Customize Toolbar:').'</p>';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '          <ul>';
			$html .= '            <li class="custom">';
			$html .= '              <input name="wordpress_toolbar_custom[]" type="checkbox" value="bloghome" id="bloghome" name="bloghome" ';
			if(in_array("bloghome",$wordpress_toolbar_custom)) { $html .= 'CHECKED/>'; } else { $html .= '/>'; }
			$html .= '              <label for="bloghome">'.gettext('Blog Home Icon').'</label>';
			$html .= '            </li>';
			$html .= '            <li class="custom">';
			$html .= '              <input name="wordpress_toolbar_custom[]" type="checkbox" value="referpost" id="referpost" name="referpost" ';
			if(in_array("referpost",$wordpress_toolbar_custom)) { $html .= 'CHECKED/>'; } else { $html .= '/>'; }
			$html .= '              <label for="referpost">'.gettext('Referal Post').'</label>';
			$html .= '            </li>';
			$html .= '            <li class="custom">';
			$html .= '              <input name="wordpress_toolbar_custom[]" type="checkbox" value="socialicons" id="socialicons" name="socialicons" ';
			if(in_array("socialicons",$wordpress_toolbar_custom)) { $html .= 'CHECKED/>'; } else { $html .= '/>'; }
			$html .= '              <label for="socialicons">'.gettext('Social Icons').'</label>';
			$html .= '            </li>';
			$html .= '            <li class="custom">';
			$html .= '              <input name="wordpress_toolbar_custom[]" type="checkbox" value="commentback" id="commentback" name="commentback" ';
			if(in_array("commentback",$wordpress_toolbar_custom)) { $html .= 'CHECKED/>'; } else { $html .= '/>'; }
			$html .= '              <label for="commentback">'.gettext('Comment Back').'</label>';
			$html .= '            </li>';
			$html .= '            <li class="custom">';
			$html .= '              <input name="wordpress_toolbar_custom[]" type="checkbox" value="leavetoolbar" id="leavetoolbar" name="leavetoolbar" ';
			if(in_array("leavetoolbar",$wordpress_toolbar_custom)) { $html .= 'CHECKED/>'; } else { $html .= '/>'; }
			$html .= '              <label for="leavetoolbar">'.gettext('Leave Toolbar').'</label>';
			$html .= '            </li>';
			$html .= '            <li class="custom">';
			$html .= '              <input name="wordpress_toolbar_custom[]" type="checkbox" value="getplugin" id="getplugin" name="getplugin" ';
			if(in_array("getplugin",$wordpress_toolbar_custom)) { $html .= 'CHECKED/>'; } else { $html .= '/>'; }
			$html .= '              <label for="getplugin">'.gettext('Get this Plugin').'</label>';
			$html .= '          </ul>';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '          <p>Choose a skin:</p>';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '          <ul>';
			foreach($skins as $skin) {
				$html .= '            <li class="skins">';
				$html .= '              <input name="wordpress_toolbar_skin" type="radio" value="'.$skin.'" id="'.$skin.'" ';
				if($wordpress_toolbar_skin == $skin) $html .= 'CHECKED/>'; else $html .= '/>';
				$html .= '              <label for="'.$skin.'">'.file_get_contents($skins_dir."/".$skin."/readme.txt").'</label>';
				$html .= '            </li>';
			}
			$html .= '          </ul>';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '          <p>'.gettext('Miscelleneous:').'</p>';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '          <ul>';
			$html .= '            <li class="custom">';
			$html .= '              <input type="checkbox" id="oinw" value="oinw" name="wordpress_toolbar_oinw" ';
			if($wordpress_toolbar_oinw == "oinw") $html .= 'CHECKED/>'; else $html .= '/>';
			$html .= '              <label for="oinw">target="_blank"</label>';
			$html .= '            </li>';
			$html .= '            <li class="custom">';
			$html .= '              <input type="checkbox" id="sociable" value="sociable" name="wordpress_toolbar_sociable" ';
			if($wordpress_toolbar_sociable == "sociable") $html .= 'CHECKED/>'; else $html .= '/>';
			$html .= '              <label for="sociable">'.gettext('Enable Sociable').'</label>';
			$html .= '            </li>';
			$html .= '            <li class="custom">';
			$html .= '              <input type="checkbox" id="tinyurl" value="tinyurl" name="wordpress_toolbar_tinyurl" ';
			if($wordpress_toolbar_tinyurl == "tinyurl") $html .= 'CHECKED/>'; else $html .= '/>';
			$html .= '              <label for="tinyurl">'.gettext('Enable Tinyurl').'</label>';
			$html .= '            </li>';
			$html .= '          </ul>';
			$html .= '          <small><br/><br/>';
			$html .= '            1. <b>target="_blank"</b>: '.gettext('Enabling this will force open urls in a new window.<br/>');
			$html .= '            2. <b>Enable Social</b>: '.gettext('It will add the above selected social icons at the end of every post.<br/>');
			$html .= '            3. <b>Enable Tinyurl</b>: '.gettext('It will auto submit your blogs to tinyurl.com and display tiny url at end of every post.<br/>');
			$html .= '          </small>';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '          <p class="submit">';
			$html .= '            <input type="submit" value="Update Options &#187;" name="wordpress_toolbar_administration"/>';
			$html .= '          </p>';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '    </table>';
			echo $html;
			  	
			if(function_exists('wp_nonce_field')) wp_nonce_field('wordpress_toolbar_update_options');
			  
			$html = '  </form>';
				
			$html .= '    <table cellspacing="0" cellpadding="0" border="0" style="padding:20px;border-top:2px dotted #444444; width:100%;">';	
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '          <p>'.gettext('FAQ\'s:').'</p>';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '          <a href="http://abhinavsingh.com/blog/2009/02/wordpress-toolbar-plugin/" target="_blank">'.gettext('Visit Wordpress Toolbar Official Home').'</a>';
			$html .= '          <br/>('.gettext('developed and maintained by').' <a href="http://abhinavsingh.com" target="_blank">Abhinav Singh</a>)';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '          <p>'.gettext('Rate it:').'</p>';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '          '.gettext('If you like this plugin, consider giving it a good rating at').' <br/><a href="http://wordpress.org/extend/plugins/wordpress-toolbar/" target="_blank">Wordpress Toolbar Page</a> on Wordpress.org';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '      <tr>';
			$html .= '        <td class="left">';
			$html .= '          <p>'.gettext('Pay Back:').'</p>';
			$html .= '        </td>';
			$html .= '        <td class="right">';
			$html .= '	    <form style="padding:0px;" action="https://www.paypal.com/cgi-bin/webscr" method="post">';
			$html .= '	      <input type="hidden" name="cmd" value="_s-xclick">';
			$html .= '	      <input type="hidden" name="hosted_button_id" value="FST5VCVJ6QEHG">';
			$html .= '	      <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">';
			$html .= '	      <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">';
			$html .= '	    </form>';
			$html .= '        </td>';
			$html .= '      </tr>';
			$html .= '      <tr><td><div class="seperator"></div></td></tr>';
			$html .= '    </table>';
			
			$html .= '</div>';
			
			echo $html;
		}
		
		function addToolbar($html) {
			global $wordpress_toolbar_social_sites;

			$home_url = get_bloginfo('url');
			$home_title = get_bloginfo('name');
			$blog_url = get_permalink();
			$blog_title = the_title('','',FALSE);
			
			$toolbar_url = get_option("wordpress_toolbar_url");
			$wptb_js_url = $home_url."/wp-content/plugins/wordpress-toolbar/wp-toolbar.js?v=2.2";

			$wordpress_toolbar_excludedomains = get_option("wordpress_toolbar_excludedomains");
			$wordpress_toolbar_excludedomains = explode(",", $wordpress_toolbar_excludedomains);
			$wordpress_toolbar_oinw = get_option("wordpress_toolbar_oinw");
			$wordpress_toolbar_social = get_option("wordpress_toolbar_social");
			$wordpress_toolbar_social = explode(",",$wordpress_toolbar_social);
			$wordpress_toolbar_sociable = get_option("wordpress_toolbar_sociable");
			$wordpress_toolbar_tinyurl = get_option("wordpress_toolbar_tinyurl");

			$links = array();
			preg_match_all('/<a[\s]+[^>]*href\s*=\s*[\"\']?([^\'\" >]+)[\'\" >]/i', $html, $m);
			foreach($m[1] as $rel_link) {
				$rel_link = trim($rel_link);

				$js = strpos(strtolower($rel_link), "javascript");
				if($js === FALSE || $js != 0) {
					$abs_link = $this->rel2abs($home_url, $rel_link);
					
					$match = 0;
					if(count($wordpress_toolbar_excludedomains) > 0) {
						foreach($wordpress_toolbar_excludedomains as $xdomain) {
							if($xdomain != '' && strstr($abs_link, $xdomain))
								$match++;
						}
					}
					
					if($match == 0) {
						if($rel_link != $abs_link)
							str_replace($rel_link, $abs_link, $html);
						$links[] = $abs_link;
					}
				}
			}
			
			if($wordpress_toolbar_sociable == "sociable" && (is_single() || is_page())) {
				$per = urlencode($blog_url);
				$tit  = urlencode($blog_title);
				$tit = str_replace('+','%20',$tit);
				 
			      	$html .= '<div style="margin-top:10px;">';
			      	$html .= '  <strong>Share and Enjoy</strong>';
				$html .= '</div>';
				$html .= '<ul style="margin-top:5px !important">';
				$html .= '<li style="list-style-type:none; display:inline !important; margin-left:5px !important">';
				foreach($wordpress_toolbar_social as $key => $social) {
					if(isset($wordpress_toolbar_social_sites[$social])) {
						$html .= '<a class="bookmarks" title="'.$social.'" href="'.str_replace(array('PERMALINK','TITLE'),array($per,$tit),$wordpress_toolbar_social_sites[$social]['url']).'">';
						$favicon = '';
						$parse_url = parse_url($wordpress_toolbar_social_sites[$social]['url']);
						if(isset($parse_url['host'])) {
							$favicon = "http://www.google.com/s2/favicons?domain=".$parse_url['host'];
						}
						else if($key == 'email_link') {
							$favicon = $extra."/socialicons/email_link.png";
						}
						else if($key == 'printer') {
							$favicon = $extra."/socialicons/printer.png";
						}
						$html .= '<img title="'.$social.'" src="'.$favicon.'" style="border:0 none; float:none; height:16px; margin:0; padding:0; width:16px; margin-right:10px;"/>';
						$html .= '</a>';
					}
				}
				$html .= '</li>';
				$html .= '</ul>';
			}

			if($wordpress_toolbar_tinyurl == "tinyurl" && (is_single() || is_page())) {
		      		$urltofetch = "http://tinyurl.com/api-create.php?url=".$blog_url;
			  	$tinyurl = $this->curlURL($urltofetch);
			  	$html .= '<div style="margin-top:10px;">';
			      	$html .= '  <strong>Tinyurl for this post</strong>';
			      	$html .= '</div>';
				$html .= '<ul style="margin-top:5px !important">';
				$html .= '  <li style="list-style-type:none; display:inline !important; margin-left:5px !important">';
				$html .= '    <a href="'.$tinyurl.'">'.$tinyurl.'</a>';
				$html .= '  </li>';
				$html .= '</ul>';
			}

			$html .= '<script type="text/javascript">';
			$html .= 'var wordpress_toolbar_urls = '.json_encode($links).';';
			$html .= 'var wordpress_toolbar_url = "'.$toolbar_url.'";';
			$html .= 'var wordpress_toolbar_oinw = "'.$wordpress_toolbar_oinw.'";';
			$html .= 'var wordpress_toolbar_hash = "'.urlencode(base64_encode($blog_url.'<wptb>'.$blog_title.'<wptb>'.$home_url.'<wptb>'.$home_title)).'";';
			$html .= '</script>';
			
			return $html;
		}

		function getToolbarHTML($param) {
			$extra = $param[5];
			$fromurl = $param[0];
			$fromtitle = $param[1];
			$blogurl = $param[2];
			$blogtitle = $param[3];
			$tourl = $param[4];
			$wordpress_toolbar_skin = $param[8];
			$wordpress_toolbar_custom = explode(",", $param[7]);
			$wordpress_toolbar_social = $param[6];

			global $wordpress_toolbar_social_sites;

			$html = '';
			$html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
			$html .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="'.get_bloginfo('language').'" dir="'.get_bloginfo('text_direction').'">';
			$html .= '<head profile="http://gmpg.org/xfn/11">';
			$html .= '<meta http-equiv="Content-Type" content="'.get_bloginfo('html_type').'; charset='.get_bloginfo('charset').'" />';
    			$html .= '<title>'.$blogtitle.' - '.gettext('Wordpress Toolbar').'</title>';
    			$html .= '<link rel="stylesheet" href="'.$extra.'/skins/'.$wordpress_toolbar_skin.'/style.css" type="text/css"/>';
  			$html .= '</head>';
  			$html .= '<body style="">';
			$html .= '<iframe frameborder="0" noresize="noresize" src="'.$tourl.'" style="position: absolute; background: transparent; width: 100%; height:100%; top: 0; padding: 32px 0; z-index: 1;"></iframe>';
			$html .= '<div class="webtoolbar" style="background-image:url('.$extra.'/skins/'.$wordpress_toolbar_skin.'/background.gif);">';
      			$html .= '<ul class="right">';
        		if(in_array("socialicons",$wordpress_toolbar_custom)) {
          			$html .= '<li style="margin-right:5px;">';
            			foreach($wordpress_toolbar_social as $key => $social) {
              				if(isset($wordpress_toolbar_social_sites[$social])) {
                				$html .= '<a class="bookmarks" title="'.$social.'" href="'.str_replace(array('PERMALINK','TITLE'),array($fromurl,$fromtitle),$wordpress_toolbar_social_sites[$social]['url']).'">';
                    				$favicon = '';
                    				$parse_url = parse_url($wordpress_toolbar_social_sites[$social]['url']);
                    				if($social == 'email_link') {
                      					$favicon = $extra."/socialicons/email_link.png";
                    				}
                    				else if($social == 'printer') {
                      					$favicon = $extra."/socialicons/printer.png";
                    				}
                    				else if(isset($parse_url['host'])) {
                      					$favicon = "http://www.google.com/s2/favicons?domain=".$parse_url['host'];
                    				}
                  				$html .= '<img src="'.$favicon.'"/>';
                				$html .= '</a>';
             				}		
            			}
          			$html .= '</li>';
			}
			if(in_array("commentback",$wordpress_toolbar_custom)) {
				$html .= '<li style="margin-top:5px; margin-right:10px;">';
			    	$html .= '<div class="btn" style="background-image:url('.$extra.'/skins/'.$wordpress_toolbar_skin.'/button_left.gif);">';
			      	$html .= '<a class="'.$wordpress_toolbar_skin.'" href="'.$fromurl.'/#comments" style="padding-left:4px; background:url('.$extra.'/skins/'.$wordpress_toolbar_skin.'/button_right.gif) no-repeat scroll right top;">'.gettext('Comment back').'</a>';
			    	$html .= '</div>';
			  	$html .= '</li>';
			}
			if(in_array("getplugin",$wordpress_toolbar_custom)) {	
				$html .= '<li style="margin-top:5px; margin-right:10px;">';
				$html .= '<div class="btn" style="background-image:url('.$extra.'/skins/'.$wordpress_toolbar_skin.'/button_left.gif);">';
				$html .= '<a class="'.$wordpress_toolbar_skin.'" href="http://wordpress.org/extend/plugins/wordpress-toolbar/" style="padding-left:4px; background:url('.$extra.'/skins/'.$wordpress_toolbar_skin.'/button_right.gif) no-repeat scroll right top;">'.gettext('Get this plugin').'</a>';
				$html .= '</div>';
				$html .= '</li>';
			}
			if(in_array("leavetoolbar",$wordpress_toolbar_custom)) {
				$html .= '<li class="mgnRightLg">';
			    	$html .= '<a id="closeButton" class="tips" title="'.gettext('Leave this toolbar').'" href="'.$tourl.'">';
			      	$html .= '<img src="'.$extra.'/skins/'.$wordpress_toolbar_skin.'/close.gif" class="'.$wordpress_toolbar_skin.'"/>';
				$html .= '</a>';
			  	$html .= '</li>';
			}
		    	$html .= '</ul>';
		      	$html .= '<ul>';
			if(in_array("bloghome",$wordpress_toolbar_custom)) {
				$html .= '<li>';
			    	$html .= '<a class="mgnRight" title="'.gettext('Go to ').$blogtitle.'" href="'.$blogurl.'">';
			      	$html .= '<img src="'.$extra.'/skins/'.$wordpress_toolbar_skin.'/home.gif"/>';
			    	$html .= '</a>';
			  	$html .= '</li>';
			}
			if(in_array("referpost",$wordpress_toolbar_custom)) {
				$html .= '<li>';
			    	$html .= '<p class="blogname">';
			      	$html .= '<i>';
				$html .= '<a title="'.gettext('Go back to ').$fromtitle.'" href="'.$fromurl.'" class="previouspost">';
				$html .= $fromtitle;
				$html .= '</a>';
			      	$html .= '</i>';
			    	$html .= '</p>';
			  	$html .= '</li>';
			}
		      	$html .= '</ul>';
		      	$html .= '<div style="clear:both"></div>';
		    	$html .= '</div>';
		  	$html .= '</body>';
			$html .= '</html>';
			return $html;
		}

		function getSociableHTML() {
			$html = '';
			return $html;
		}

		function curlUrl($URL) {
			$c = curl_init();
		    	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		  	curl_setopt($c, CURLOPT_URL, $URL);
		  	$contents = curl_exec($c);
	  		curl_close($c);
	  	
	  		if($contents) return $contents;
  			else return FALSE;	  
		}
		
		function rel2abs($absolute, $relative) {					
  			$p = @parse_url($relative);
			
			if(!$p) return false;
			
			if(isset($p["scheme"])) return $relative;
  			$parts=(parse_url($absolute));
  
  			if(substr($relative,0,1)=='/') {
    				$cparts = (explode("/", $relative));
    				array_shift($cparts);
  			} 
		  	else {
		    		if(isset($parts['path'])) {
		      			$aparts=explode('/',$parts['path']);
		      			array_pop($aparts);
		      			$aparts=array_filter($aparts);
		    		} 
		    		else {
		      			$aparts=array();
		    		}
			    	$rparts = (explode("/", $relative));
			    	$cparts = array_merge($aparts, $rparts);
			    	foreach($cparts as $i => $part) {
			      		if($part == '.') {
			      			unset($cparts[$i]);
			      		} 
			      		else if($part == '..') {
						unset($cparts[$i]);
						unset($cparts[$i-1]);
			      		}
				}	
			}
			$path = implode("/", $cparts);
			$url = '';
			if($parts['scheme']) {
				$url = "$parts[scheme]://";
			}
			if(isset($parts['user'])) {
			    	$url .= $parts['user'];
			    	if(isset($parts['pass'])) {
			      		$url .= ":".$parts['pass'];
			    	}
			    	$url .= "@";
			}
			if(isset($parts['host'])) {
			    	$url .= $parts['host']."/";
			}
			$url .= $path;
			  
			return $url;
		}		

	}

?>
