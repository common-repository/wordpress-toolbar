=== Wordpress Toolbar ===
Contributors: imoracle
Donate link: http://abhinavsingh.com/blog/2009/02/wordpress-toolbar-plugin/
Tags: wordpress, toolbar, plugin, social, comment
Requires at least: 2.6
Tested up to: 2.9.2
Stable tag: 2.2.6

WordPress Toolbar (supports WPMU since v 2.2) is a unique plugin which automatically enables a toolbar for all outgoing links from your blog post, similar to stumbleupon or facebook toolbar. You can customize the widgets that will show up on the toolbar using the admin panel. Once the plugin is enabled, whenever someone clicks on an outbound link from your blog post or page, it will open with wordpress toolbar at the top.

== Description ==
WordPress Toolbar (supports WPMU since v 2.2) is a unique plugin which automatically enables a toolbar for all outgoing links from your blog post, similar to stumbleupon or facebook toolbar. You can customize the widgets that will show up on the toolbar using the admin panel.

Once the plugin is enabled, whenever someone clicks on an outbound link from your blog post or page, it will open with wordpress toolbar at the top. By default wordpress toolbar shows following widgets on the toolbar (all widgets can be enabled/disabled from admin panel):

1. Link back to your blog home
2. Link back to your blog post/page from where user came to this toolbar
3. A list of social share icons (defaults to twitter,facebook,stumbleupon,...) using which the user can share your blog post/page
4. Comment back link to the referrer blog post
5. Get this plugin link which by default points to http://wordpress.org/extend/plugins/wordpress-toolbar/
6. Leave toolbar (shown as a cross button), using which user can leave this toolbar

Since v 2.1, Wordpress toolbar also provide following features:

1. Sociable Share Icons (Disabled by default): If enabled plugin will display social share icons at end of each blog post/page
2. TinyURL Share Link (Disabled by default): If enabled plugin will display a tinyurl at end of each blog post/page.

== Installation ==

= Installing 2.x series plugin =

1. Download the plugin
2. Extract the plugin into `/wp-content/plugins/wordpress-toolbar` directory
5. Activate the plugin
6. Go to `wp-admin` => `Settings` => `Wordpress Toolbar` and customize the toolbar
7. Read <a href="http://abhinavsingh.com/blog/2010/02/wordpress-toolbar-v-2-2-custom-toolbar-url-support-for-wpmu-and-bug-fixes/">setup steps</a> to customize the toolbar url 

= Removing 1.x series plugin =

1. Before proceeding with version 2.x, you should DEACTIVATE any active 1.x series plugin
2. Remove `/blog/toolbar.php` which you must have copied while activating 1.x version
3. Remove `/blog/wp-content/plugins/wp-toolbar` directory fully. You will no longer need this

== Changelog ==

= 2.2.7 =
Feature: Added support for internationalization of plugin

= 2.2.6 =
Bug: Fixed excluded domain not working problem
Feature: Added PayPal donation button in admin panel

= 2.2.5 =
Bug: Removed toolbar from javascript:void() style links

= 2.2.4 =
Feature: An option to remove "Get this plugin" widget from the toolbar. (Enabled by default and points to this page)

= 2.2.3 =
Bug: Fixed browser side script error on admin and blog home page
Bug: Fixed missing "DO READ Setup Step" link in admin panel

= 2.2 =
Feature: Support for WPMU released.
Feature: Blog admins can now customize the toolbar url.
Security: Added security checks to avoid possible XSS attacks
Bug: Fixed cross plugin compatibility issues

= 2.1.x =
Feature: Support for tinyurl shortner service
Feature: Support for sociable – adding social share icons at the end of every post
Feature: Facebook skin bundled with plugin
Feature: target=”_blank” support added
Feature: Plugin is now PHP4 compatible

= 1.1 =
Bug: Include emergency CSS and HTML Validation fixes for IE browsers

= 1.0 =
The first release of wordpress toolbar plugin

== Frequently Asked Questions ==

= Why should I Install Wordpress Toolbar =
Often visitors on a blog clicks one of the outgoing link. However, they often forget to comment back or social bookmark your blog post. WordPress toolbar plugin tries to solve this with a toolbar on top of all these outgoing links from your blog post. 

= How will the floating toolbar help? =
Following widgets are enabled by default (you can control them from admin panel)

1. Link back to your blog home
2. Link back to your blog post/page from where user came to this toolbar
3. A list of social share icons (defaults to twitter,facebook,stumbleupon,...) using which the user can share your blog post/page
4. Comment back link to the referrer blog post
5. Get this plugin link which by default points to http://wordpress.org/extend/plugins/wordpress-toolbar/
6. Leave toolbar (shown as a cross button), using which user can leave this toolbar

= What skins are made available for the toolbar? = 
Wordpress Toolbar Plugin comes with two skins. Stumbleupon (su) and Facebook (fb).
"su" is the default skin (darker shade)
"fb" can be enabled from admin panel (lighter shade)

= But default skins don't suit my blog theme. What can I do? =
Don't worry. Wordpress toolbar provides a simple solution for this problem.
Read <a href="http://abhinavsingh.com/blog/2009/06/wordpress-toolbar-v-2-1-adding-support-for-tinyurl-sociable-and-a-lot-more/">this blog post</a> for steps to enable your custom skin without touching a piece of code.

= No, I want even more customization. How can I do that? =
Fortunately we have a solution for this too.
Support this plugin through donation and as a pay back plugin author will get you your custom toolbar.
You can even contacting plugin author directly http://abhinavsingh.com/blog for customization

= I have more queries, where can I ask them? =
Post your comment, queries, appreciation, hatred at one of the post listed below:
<a href="http://abhinavsingh.com/blog/2009/02/wordpress-toolbar-plugin/">Wordpress Toolbar Plugin Release Blog</a>

<a href="http://abhinavsingh.com/blog/2010/02/wordpress-toolbar-v-2-2-custom-toolbar-url-support-for-wpmu-and-bug-fixes/">Wordpress Toolbar v 2.1 – Adding support for tinyurl, sociable and a lot more</a> 

<a href="http://abhinavsingh.com/blog/2010/02/wordpress-toolbar-v-2-2-custom-toolbar-url-support-for-wpmu-and-bug-fixes/">Wordpress Toolbar v 2.2 : Custom toolbar url, Support for WPMU and bug fixes</a>

== Screenshots ==

1. Visit <a href="http://abhinavsingh.com/blog/2009/02/wordpress-toolbar-plugin/">Wordpress Toolbar Release Page</a>
2. Click on any of the outgoing link to view a demo of this plugin
